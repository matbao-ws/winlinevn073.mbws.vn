<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FanCalculation;
use App\Services\Catalog\ProductQueryService;
use App\Services\HVAC\FanCalculationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CalculatorController extends Controller
{
    public function __construct(
        private readonly ProductQueryService $products,
        private readonly FanCalculationService $fanService,
    ) {}

    /**
     * Main Calculator View
     */
    public function index(Request $request, string $locale): View
    {
        $activeTab = $request->query('tab', 'thong-gio-hut-khi');
        if (!in_array($activeTab, ['thong-gio-hut-khi', 'cooling-pad', 'thong-gio-phong'], true)) {
            $activeTab = 'thong-gio-hut-khi';
        }

        // Default initial parameters per tab
        $defaults = match ($activeTab) {
            'cooling-pad' => [
                'area' => 200,
                'height' => 6.0,
                'boiso' => 60,
                'voltage' => '380V',
                'space_type' => 'nha_xuong',
            ],
            'thong-gio-phong' => [
                'area' => 50,
                'height' => 3.0,
                'boiso' => 6,
                'voltage' => '220V',
                'space_type' => 'cong_so',
            ],
            default => [
                'area' => 3000,
                'height' => 3.0,
                'boiso' => 20,
                'voltage' => '380V',
                'space_type' => 'nha_xuong',
            ],
        };

        // Override defaults if present in query params
        $area = (float) $request->query('area', $defaults['area']);
        $height = (float) $request->query('height', $defaults['height']);
        $boiso = (float) $request->query('boiso', $defaults['boiso']);
        $voltage = (string) $request->query('voltage', $defaults['voltage']);
        $spaceType = (string) $request->query('space_type', $defaults['space_type']);

        // Calculate initial flow
        $initialCalc = match ($activeTab) {
            'cooling-pad' => $this->fanService->computeTab2($area, $height, $boiso, $voltage),
            'thong-gio-phong' => $this->fanService->computeTab3($area, $height, $spaceType, $voltage),
            default => $this->fanService->computeTab1($area, $height, $boiso, $voltage),
        };

        $requiredAirflow = (float) ($initialCalc['required_airflow'] ?? 0);

        // Fetch candidate products (max 6)
        $candidateFans = $this->fanService->queryCandidateFans(
            tab: $activeTab,
            requiredAirflow: $requiredAirflow,
            filters: ['voltage' => $voltage],
            locale: $locale
        );

        // Fetch filter options for active tab
        $filterOptions = $this->fanService->getFilterOptions($activeTab);

        // Space types for Tab 3 from Phụ lục G
        $spaceTypesPhuLucG = FanCalculationService::SPACE_TYPES_PHU_LUC_G;

        // Standard cooling pads for Tab 2
        $coolingPadCatalog = FanCalculationService::STANDARD_COOLING_PADS;

        return view('client.pages.calculator', [
            'activeTab' => $activeTab,
            'initialCalc' => $initialCalc,
            'candidateFans' => $candidateFans,
            'filterOptions' => $filterOptions,
            'spaceTypesPhuLucG' => $spaceTypesPhuLucG,
            'coolingPadCatalog' => $coolingPadCatalog,
            'coolingPadVelocity' => FanCalculationService::COOLING_PAD_VELOCITY,
        ]);
    }

    /**
     * API: Query candidate fans based on live inputs and filters
     */
    public function apiProducts(Request $request, string $locale): JsonResponse
    {
        $tab = (string) $request->input('tab', 'thong-gio-hut-khi');
        $requiredAirflow = (float) $request->input('required_airflow', 0);
        $voltage = (string) $request->input('voltage', 'all');

        $filters = [
            'voltage' => $voltage,
            'brand' => $request->input('brand'),
            'fan_type' => $request->input('fan_type'),
            'size' => $request->input('size'),
            'price_range' => $request->input('price_range'),
        ];

        $fans = $this->fanService->queryCandidateFans($tab, $requiredAirflow, $filters, $locale);
        $filterOptions = $this->fanService->getFilterOptions($tab);

        return response()->json([
            'success' => true,
            'tab' => $tab,
            'products' => $fans,
            'filter_options' => $filterOptions,
        ]);
    }

    /**
     * API: Balance selected fans (primary auto-balances, max 3 items) and cooling pads
     */
    public function balance(Request $request, string $locale): JsonResponse
    {
        $tab = (string) $request->input('tab', 'thong-gio-hut-khi');
        $requiredAirflow = (float) $request->input('required_airflow', 0);
        $items = (array) $request->input('items', []);
        $selectedPads = (array) $request->input('cooling_pads', []);

        $balanceResult = $this->fanService->balanceSelection($requiredAirflow, $items);

        $padResult = null;
        $grandTotal = $balanceResult['total_price'];

        if ($tab === 'cooling-pad') {
            $padResult = $this->fanService->computeCoolingPads(
                $balanceResult['total_actual_airflow'],
                $selectedPads
            );
            $grandTotal += $padResult['total_pad_price'];
        }

        return response()->json([
            'success' => true,
            'balance' => $balanceResult,
            'cooling_pads' => $padResult,
            'grand_total' => $grandTotal,
            'formatted_grand_total' => number_format($grandTotal, 0, ',', '.') . ' đ',
        ]);
    }

    /**
     * API: Save calculation session snapshot to database
     */
    public function save(Request $request, string $locale): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tab' => 'required|string|in:thong-gio-hut-khi,cooling-pad,thong-gio-phong',
            'inputs' => 'required|array',
            'results' => 'required|array',
            'selected_items' => 'nullable|array',
            'customer' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $calculation = new FanCalculation();
        $calculation->public_id = FanCalculation::generatePublicId();
        $calculation->tab = $request->input('tab');
        $calculation->inputs = $request->input('inputs');
        $calculation->results = $request->input('results');
        $calculation->selected_items = $request->input('selected_items', []);

        if ($request->filled('customer.name')) {
            $calculation->customer_name = $request->input('customer.name');
            $calculation->customer_phone = $request->input('customer.phone');
            $calculation->customer_email = $request->input('customer.email');
            $calculation->company_name = $request->input('customer.company');
            $calculation->tax_code = $request->input('customer.tax_code');
        }

        $calculation->status = 'draft';
        $calculation->save();

        $detailUrl = route('client.calculator.estimation', ['locale' => $locale, 'publicId' => $calculation->public_id]);
        $pdfUrl = route('client.calculator.pdf', ['locale' => $locale, 'publicId' => $calculation->public_id]);

        return response()->json([
            'success' => true,
            'public_id' => $calculation->public_id,
            'url' => $detailUrl,
            'pdf_url' => $pdfUrl,
            'message' => 'Bản dự tính đã được lưu thành công!',
        ]);
    }

    /**
     * Web view for saved estimation
     */
    public function showEstimation(string $locale, string $publicId): View
    {
        $calculation = FanCalculation::where('public_id', $publicId)->firstOrFail();

        return view('client.pages.estimation-detail', [
            'calculation' => $calculation,
            'publicId' => $publicId,
        ]);
    }

    /**
     * Printable A4 / PDF view for saved estimation
     */
    public function pdf(string $locale, string $publicId): View
    {
        $calculation = FanCalculation::where('public_id', $publicId)->firstOrFail();

        return view('client.pdf.fan-calculation', [
            'calculation' => $calculation,
            'publicId' => $publicId,
        ]);
    }

    /**
     * Submit RFQ / Contact to Winline with estimation snapshot
     */
    public function submitRfq(Request $request, string $locale, string $publicId): JsonResponse
    {
        $calculation = FanCalculation::where('public_id', $publicId)->firstOrFail();

        $validated = $request->validate([
            'customer_name' => 'required|string|max:150',
            'customer_phone' => 'required|string|max:50',
            'customer_email' => 'nullable|email|max:150',
            'company_name' => 'nullable|string|max:200',
            'tax_code' => 'nullable|string|max:50',
            'customer_note' => 'nullable|string|max:1000',
        ]);

        $calculation->update([
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'] ?? null,
            'company_name' => $validated['company_name'] ?? null,
            'tax_code' => $validated['tax_code'] ?? null,
            'customer_note' => $validated['customer_note'] ?? null,
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        $detailUrl = route('client.calculator.estimation', ['locale' => $locale, 'publicId' => $calculation->public_id]);
        $totalVnd = number_format($calculation->results['grand_total'] ?? ($calculation->results['total_price'] ?? 0), 0, ',', '.') . ' đ';

        // Pre-formatted Zalo message for sharing with Winline hotline 0949.761.888
        $zaloMsg = "Chào Winline Việt Nam! Tôi là {$validated['customer_name']} (SĐT: {$validated['customer_phone']}). "
            . "Tôi vừa lập Bản dự tính quạt [{$calculation->public_id}] trên website với tổng dự tính {$totalVnd}. "
            . "Kính nhờ Winline kiểm tra và báo giá chính thức giúp tôi: {$detailUrl}";

        $zaloUrl = 'https://zalo.me/0949761888?text=' . urlencode($zaloMsg);

        return response()->json([
            'success' => true,
            'message' => 'Yêu cầu dự tính đã được gửi tới Winline Việt Nam thành công!',
            'zalo_url' => $zaloUrl,
            'zalo_message' => $zaloMsg,
        ]);
    }
}
