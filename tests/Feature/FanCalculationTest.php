<?php

namespace Tests\Feature;

use App\Models\FanCalculation;
use App\Models\Product;
use App\Services\HVAC\FanCalculationService;
use Database\Seeders\FanProductsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FanCalculationTest extends TestCase
{
    use RefreshDatabase;

    private FanCalculationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(FanProductsSeeder::class);
        $this->service = app(FanCalculationService::class);
    }

    /**
     * Test TG-01 Benchmark from Winline Excel v05 Sheet 06:
     * Area: 3000, Height: 3, ACH: 20 -> Volume = 9000, Required Airflow = 180,000 m3/h
     * Fan airflow: 46,000 -> Quantity: ROUNDUP(180000/46000) = 4 fans
     * Total airflow: 184,000 m3/h -> Delta: +2.22% (within +-5%)
     */
    public function test_benchmark_tg_01_formula_and_tolerance(): void
    {
        $calc = $this->service->computeTab1(3000, 3, 20, '380V');
        $this->assertEquals(9000, $calc['volume']);
        $this->assertEquals(180000, $calc['required_airflow']);

        $selection = [
            [
                'sku' => 'KM-1380-46K',
                'name' => 'Quạt thông gió vuông Komasu KM-1380',
                'airflow' => 46000,
                'unit_price' => 4250000,
                'is_primary' => true,
            ]
        ];

        $balanced = $this->service->balanceSelection($calc['required_airflow'], $selection);
        $this->assertEquals(4, $balanced['items'][0]['quantity']);
        $this->assertEquals(184000, $balanced['total_actual_airflow']);
        $this->assertEquals(2.22, $balanced['delta_percent']);
        $this->assertTrue($balanced['is_in_tolerance']);
    }

    /**
     * Test TG-02 Benchmark from Winline Excel v05 Sheet 06:
     * Area: 290, Height: 3, ACH: 20 -> Volume = 870, Required Airflow = 17,400 m3/h
     * Fan airflow: 3,080 -> Quantity: ROUNDUP(17400/3080) = 6 fans
     * Total airflow: 18,480 m3/h -> Delta: +6.21% (outside +-5% -> warning)
     */
    public function test_benchmark_tg_02_warning_tolerance(): void
    {
        $calc = $this->service->computeTab1(290, 3, 20);
        $this->assertEquals(17400, $calc['required_airflow']);

        $selection = [
            [
                'sku' => 'DASIN-KVF-1845',
                'airflow' => 3080,
                'unit_price' => 1850000,
                'is_primary' => true,
            ]
        ];

        $balanced = $this->service->balanceSelection($calc['required_airflow'], $selection);
        $this->assertEquals(6, $balanced['items'][0]['quantity']);
        $this->assertEquals(18480, $balanced['total_actual_airflow']);
        $this->assertEquals(6.21, $balanced['delta_percent']);
        $this->assertFalse($balanced['is_in_tolerance']);
    }

    /**
     * Test CP-01, CP-02, CP-03 Cooling Pad Benchmarks:
     * Area: 200, Height: 6, ACH: 60 -> Volume = 1200, Required Airflow = 72,000 m3/h
     * Fan airflow: 48,000 (LF1380) -> Quantity: ROUNDUP(72000/48000) = 2 fans
     * Total Fan Airflow: 96,000 m3/h
     * Cooling Pad Area required based on actual fan airflow: 96,000 / 9,000 = 10.67 m2
     * Standard pad 1800x1500 (area = 2.70 m2): ROUNDUP(10.67 / 2.70) = 4 pads -> Total area = 10.8 m2
     */
    public function test_benchmark_cp_01_cooling_pad_calculations(): void
    {
        $calc = $this->service->computeTab2(200, 6, 60, '380V');
        $this->assertEquals(1200, $calc['volume']);
        $this->assertEquals(72000, $calc['required_airflow']);

        $selection = [
            [
                'sku' => 'LF1380',
                'airflow' => 48000,
                'unit_price' => 4350000,
                'is_primary' => true,
            ]
        ];

        $balanced = $this->service->balanceSelection($calc['required_airflow'], $selection);
        $this->assertEquals(2, $balanced['items'][0]['quantity']);
        $this->assertEquals(96000, $balanced['total_actual_airflow']);

        // Pad area computed from actual fan airflow (96,000 m3/h)
        $padResult = $this->service->computeCoolingPads($balanced['total_actual_airflow']);
        $this->assertEquals(10.67, $padResult['required_pad_area']);

        // Check 1800x1500 pad option
        $pad1815 = collect($padResult['pad_options'])->firstWhere('sku', 'PAD-1800X1500');
        $this->assertNotNull($pad1815);
        $this->assertEquals(2.7, $pad1815['area_per_unit']);
        $this->assertEquals(4, $pad1815['recommended_qty']); // ROUNDUP(10.67 / 2.7) = 4
        $this->assertEquals(10.8, $pad1815['supplied_area']);
        $this->assertTrue($pad1815['is_sufficient']);
    }

    /**
     * Test Zero edge case (no division by zero)
     */
    public function test_zero_inputs_edge_case(): void
    {
        $calc = $this->service->computeTab1(0, 3, 20);
        $this->assertEquals(0, $calc['volume']);
        $this->assertEquals(0, $calc['required_airflow']);

        $balanced = $this->service->balanceSelection(0, []);
        $this->assertEquals(0, $balanced['total_actual_airflow']);
    }

    /**
     * Test Multi-item selection: Primary fan auto-balances remaining airflow
     */
    public function test_multi_selection_balancing(): void
    {
        $requiredFlow = 100000;
        $items = [
            [
                'sku' => 'PRIMARY-FAN',
                'airflow' => 40000,
                'unit_price' => 4000000,
                'is_primary' => true,
            ],
            [
                'sku' => 'SECONDARY-FAN',
                'airflow' => 15000,
                'unit_price' => 2000000,
                'quantity' => 2, // 2 * 15000 = 30000 m3/h
                'is_primary' => false,
            ]
        ];

        // Remainder for primary: 100000 - 30000 = 70000 m3/h
        // Primary quantity: ROUNDUP(70000 / 40000) = 2 fans
        // Total airflow: 2 * 40000 + 30000 = 110000 m3/h
        $balanced = $this->service->balanceSelection($requiredFlow, $items);
        $this->assertEquals(2, $balanced['items'][0]['quantity']);
        $this->assertEquals(110000, $balanced['total_actual_airflow']);
    }

    /**
     * Web & API Tests
     */
    public function test_calculator_page_loads_successfully(): void
    {
        $response = $this->get('/vi/cong-cu-tinh-quat');
        $response->assertStatus(200);
        $response->assertSee('Thông gió &ndash; hút khí', false);
        $response->assertSee('Làm mát bằng Cooling Pad', false);
        $response->assertSee('Thông gió văn phòng, phòng bếp &amp; WC', false);
    }

    public function test_api_products_endpoint(): void
    {
        $response = $this->getJson('/vi/cong-cu-tinh-quat/products?tab=thong-gio-hut-khi&required_airflow=180000&voltage=380V');
        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertLessThanOrEqual(6, count($response->json('products')));
    }

    public function test_estimation_save_and_retrieval_flow(): void
    {
        $payload = [
            'tab' => 'thong-gio-hut-khi',
            'inputs' => [
                'area' => 3000,
                'height' => 3,
                'boiso' => 20,
                'voltage' => '380V',
                'volume' => 9000,
            ],
            'results' => [
                'required_airflow' => 180000,
                'total_actual_airflow' => 184000,
                'delta_percent' => 2.22,
                'is_in_tolerance' => true,
                'total_price' => 17000000,
                'grand_total' => 17000000,
            ],
            'selected_items' => [
                [
                    'sku' => 'KM-1380-46K',
                    'name' => 'Quạt thông gió vuông Komasu KM-1380',
                    'airflow' => 46000,
                    'quantity' => 4,
                    'unit_price' => 4250000,
                    'is_primary' => true,
                ]
            ],
            'customer' => [
                'name' => 'Anh Thắng Winline',
                'phone' => '0949761888',
                'company' => 'Winline Test Co.',
            ]
        ];

        // 1. Save
        $saveRes = $this->postJson('/vi/cong-cu-tinh-quat/save', $payload);
        $saveRes->assertStatus(200);
        $saveRes->assertJsonPath('success', true);
        $publicId = $saveRes->json('public_id');
        $this->assertStringStartsWith('EST-', $publicId);

        // 2. View online estimation
        $viewRes = $this->get('/vi/du-tinh/' . $publicId);
        $viewRes->assertStatus(200);
        $viewRes->assertSee($publicId);
        $viewRes->assertSee('Anh Thắng Winline');

        // 3. View PDF printable layout
        $pdfRes = $this->get('/vi/du-tinh/' . $publicId . '/pdf');
        $pdfRes->assertStatus(200);
        $pdfRes->assertSee('CÔNG TY TNHH WINLINE VIỆT NAM');
        $pdfRes->assertSee('0106085370'); // MST

        // 4. Submit RFQ officially
        $submitRes = $this->postJson('/vi/du-tinh/' . $publicId . '/submit', [
            'customer_name' => 'Lê Quyết Thắng',
            'customer_phone' => '0949761888',
            'company_name' => 'Winline Việt Nam',
        ]);
        $submitRes->assertStatus(200);
        $submitRes->assertJsonPath('success', true);
        $this->assertStringContainsString('zalo.me', $submitRes->json('zalo_url'));
    }

    public function test_navigation_renamed_to_chon_theo_nhu_cau(): void
    {
        $response = $this->get('/vi');
        $response->assertStatus(200);
        $response->assertSee('Chọn theo nhu cầu');
        $response->assertDontSee('>Giải pháp</a>', false);
    }
}
