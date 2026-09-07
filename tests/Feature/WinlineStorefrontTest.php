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

    public function test_admin_can_login_with_winline_credentials_and_access_dashboard(): void
    {
        $response = $this->postJson('/vi/admin/login', [
            'email' => 'winlinevietnam@gmail.com',
            'password' => 'Admin@Winline2026!',
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);

        $admin = \App\Models\User::where('email', 'winlinevietnam@gmail.com')->first();
        $this->assertAuthenticatedAs($admin);

        // Verify access to key admin sections
        $adminSections = [
            '/vi/admin',
            '/vi/admin/products',
            '/vi/admin/categories',
            '/vi/admin/brands',
            '/vi/admin/orders',
            '/vi/admin/posts',
            '/vi/admin/pages',
            '/vi/admin/contact-submissions',
            '/vi/admin/settings',
        ];

        foreach ($adminSections as $section) {
            $this->actingAs($admin)->get($section)->assertOk();
        }
    }

    public function test_all_seeded_products_render_in_detail_pages(): void
    {
        $products = Product::query()->where('is_active', true)->get();
        $this->assertGreaterThan(0, $products->count());

        foreach ($products as $product) {
            $slug = $product->canonicalSlug('vi');
            $this->get('/vi/san-pham/' . $slug)
                ->assertOk()
                ->assertSee($product->name);
        }
    }

    public function test_all_seeded_posts_render_in_detail_pages(): void
    {
        $posts = \App\Models\Post::query()->where('is_active', true)->get();
        $this->assertGreaterThan(0, $posts->count());

        foreach ($posts as $post) {
            $slug = $post->canonicalSlug('vi');
            $this->get('/vi/tin-tuc/' . $slug)
                ->assertOk()
                ->assertSee($post->title);
        }
    }

    public function test_ajax_modal_quote_submission(): void
    {
        $response = $this->postJson('/vi/lien-he', [
            'name' => 'Khách hàng dự án',
            'phone' => '0912345678',
            'subject' => 'Báo giá: Quạt ly tâm hút khói PCCC',
            'message' => 'Yêu cầu báo giá nhanh qua modal website',
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);
        $this->assertDatabaseHas('contact_submissions', [
            'phone' => '0912345678',
            'name' => 'Khách hàng dự án',
        ]);
    }
}

