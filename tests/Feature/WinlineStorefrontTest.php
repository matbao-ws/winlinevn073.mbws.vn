<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\FoundationSeeder;
use Database\Seeders\WinlineStorefrontSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WinlineStorefrontTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(FoundationSeeder::class);
        $this->seed(WinlineStorefrontSeeder::class);
    }

    public function test_root_redirects_to_vi_storefront(): void
    {
        $this->get('/')->assertRedirect('/vi');
    }

    public function test_storefront_pages_render_successfully(): void
    {
        $pages = [
            '/vi',
            '/vi/gioi-thieu',
            '/vi/san-pham',
            '/vi/cong-cu-tinh-quat',
            '/vi/thuong-hieu',
            '/vi/giai-phap',
            '/vi/du-an',
            '/vi/tin-tuc',
            '/vi/lien-he',
        ];

        foreach ($pages as $url) {
            $response = $this->get($url);
            $response->assertOk();
            $response->assertSee('Winline');
        }
    }

    public function test_product_detail_page_renders_with_product_data(): void
    {
        $product = Product::query()->where('is_active', true)->firstOrFail();
        $url = '/vi/san-pham/' . $product->canonicalSlug('vi');

        $response = $this->get($url);
        $response->assertOk();
        $response->assertSee($product->name);
    }

    public function test_contact_form_submission(): void
    {
        $response = $this->post('/vi/lien-he', [
            'name' => 'Nguyễn Đức Toàn',
            'phone' => '0949761893',
            'email' => 'toan@example.com',
            'subject' => 'Dự án thông gió xưởng Bắc Ninh',
            'message' => 'Cần báo giá 15 quạt vuông 1380.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'Nguyễn Đức Toàn',
            'phone' => '0949761893',
        ]);
    }

    public function test_admin_login_is_accessible(): void
    {
        $this->get('/vi/admin/login')->assertOk()->assertSee('admin');
    }
}
