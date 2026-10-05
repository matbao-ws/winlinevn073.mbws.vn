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
            '/vi/danh-muc-san-pham',
            '/vi/chon-theo-nhu-cau',
            '/vi/cong-cu-tinh-quat',
            '/vi/thuong-hieu',
            '/vi/giai-phap',
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

    public function test_root_legacy_category_slug_redirects_301_to_localized_url(): void
    {
        $response = $this->get('/quat-tran');
        $response->assertRedirect('/vi/quat-tran');
        $response->assertStatus(301);
    }

    public function test_root_legacy_level3_slug_redirects_301_to_localized_url(): void
    {
        $response = $this->get('/quat-tran-vinawind');
        $response->assertRedirect('/vi/quat-tran-vinawind');
        $response->assertStatus(301);
    }

    public function test_localized_category_slug_resolves_successfully(): void
    {
        $response = $this->get('/vi/quat-tran');
        $response->assertOk();
        $response->assertSee('Quạt trần');
    }

    public function test_localized_level3_category_brand_slug_resolves_successfully(): void
    {
        $response = $this->get('/vi/quat-tran-vinawind');
        $response->assertOk();
        $response->assertSee('Quạt trần');
        $response->assertSee('Vinawind');
    }

    public function test_localized_brand_slug_resolves_successfully(): void
    {
        $response = $this->get('/vi/vinawind');
        $response->assertOk();
        $response->assertSee('Vinawind');
    }

    public function test_localized_flat_product_slug_resolves_successfully(): void
    {
        $response = $this->get('/vi/quat-cay-cong-nghiep-komasu-km-750s');
        $response->assertOk();
        $response->assertSee('KM-750S');
    }

    public function test_invalid_slug_returns_404(): void
    {
        $response = $this->get('/vi/khong-ton-tai-slug-xyz');
        $response->assertNotFound();
    }

    public function test_danh_muc_san_pham_contract_urls_resolve_ok(): void
    {
        // 1. Root /danh-muc-san-pham redirects 301 to /vi/danh-muc-san-pham
        $response = $this->get('/danh-muc-san-pham');
        $response->assertStatus(301);
        $response->assertRedirect('/vi/danh-muc-san-pham');

        // 2. /vi/danh-muc-san-pham must return 200 OK and show products catalog
        $response2 = $this->get('/vi/danh-muc-san-pham');
        $response2->assertOk();
        $response2->assertSee('Winline');
    }

    public function test_san_pham_contract_urls_resolve_ok(): void
    {
        // 1. Root /san-pham redirects 301 to /vi/san-pham
        $response = $this->get('/san-pham');
        $response->assertStatus(301);
        $response->assertRedirect('/vi/san-pham');

        // 2. /vi/san-pham returns 200 OK
        $response2 = $this->get('/vi/san-pham');
        $response2->assertOk();
    }

    public function test_legacy_aliases_redirect_301_to_destinations(): void
    {
        $this->get('/he-thong-lam-mat-trang-trai')
            ->assertStatus(301)
            ->assertRedirect('/vi/tam-lam-mat-cooling-pad');

        $this->get('/vi/he-thong-lam-mat-trang-trai')
            ->assertStatus(301)
            ->assertRedirect('/vi/tam-lam-mat-cooling-pad');

        $this->get('/loai-quat/quat-cong-nghiep')
            ->assertStatus(301)
            ->assertRedirect('/vi/quat-cong-nghiep');

        $this->get('/vi/loai-quat/quat-cong-nghiep')
            ->assertStatus(301)
            ->assertRedirect('/vi/quat-cong-nghiep');

        // Test additional aliases from Excel and old site
        $this->get('/vi/quat-cay-cn-komasu-km750s')
            ->assertStatus(301)
            ->assertRedirect('/vi/quat-cay-cong-nghiep-komasu-km-750s');

        $this->get('/vi/quat-cat-gio-nanyoo-fm-1209x-2-y')
            ->assertStatus(301)
            ->assertRedirect('/vi/quat-cat-gio-nanyoo-fm-5509z-l-y');

        // Test root and localized /du-an redirect 301 to /vi/gioi-thieu
        $this->get('/du-an')
            ->assertStatus(301)
            ->assertRedirect('/vi/gioi-thieu');

        $this->get('/vi/du-an')
            ->assertStatus(301)
            ->assertRedirect('/vi/gioi-thieu');

        // Test /danh-muc and /tim-kiem and /search
        $this->get('/danh-muc')->assertStatus(301)->assertRedirect('/vi/danh-muc');
        $this->get('/vi/danh-muc')->assertOk();
        $this->get('/tim-kiem')->assertStatus(301)->assertRedirect('/vi/tim-kiem');
        $this->get('/vi/tim-kiem')->assertOk();
        $this->get('/search')->assertStatus(301)->assertRedirect('/vi/search');
        $this->get('/vi/search')->assertOk();
    }

    public function test_all_12_homepage_categories_resolve_200(): void
    {
        $catSlugs = [
            'quat-tran',
            'quat-cay',
            'quat-treo-tuong',
            'quat-hop',
            'quat-thong-gio',
            'quat-cong-nghiep',
            'quat-cat-gio',
            'quat-dan-dung',
            'quat-thong-gio-vuong',
            'quat-ly-tam',
            'tam-lam-mat-cooling-pad',
        ];

        foreach ($catSlugs as $slug) {
            $this->get('/vi/' . $slug)->assertOk();
        }
    }

    public function test_header_navigation_does_not_contain_projects_link(): void
    {
        $response = $this->get('/vi');
        $response->assertOk();
        // The project route link was removed from storefront layout as requested by customer
        $response->assertDontSee('/vi/du-an');
    }

    public function test_v8_homepage_renders_all_required_blocks_and_branding(): void
    {
        $response = $this->get('/vi');
        $response->assertOk();

        // 1. Top bar 3 utility entries
        $response->assertSee('Giao hàng &amp; phí', false);
        $response->assertSee('0949 761 893');
        $response->assertSee('Địa chỉ &amp; chỉ đường', false);

        // 2. Hero Section B2B + B2C
        $response->assertSee('GIẢI PHÁP THÔNG GIÓ VÀ LÀM MÁT');
        $response->assertSee('Quạt cho gia đình');
        $response->assertSee('và nơi làm việc');
        $response->assertSee('Khám phá sản phẩm →', false);

        // 3. Khối Chọn theo nhu cầu
        $response->assertSee('Chọn theo nhu cầu');
        $response->assertSee('Quạt cho gia đình, văn phòng');
        $response->assertSee('Quạt cho nhà xưởng, kho bãi');
        $response->assertSee('Làm mát nhà xưởng');

        // 4. Khối Danh mục sản phẩm (12 ô)
        $response->assertSee('Danh mục sản phẩm');
        $response->assertSee('Xem tất cả danh mục →', false);
        $response->assertSee('Quạt trần');
        $response->assertSee('Quạt đứng');
        $response->assertSee('Quạt treo tường');
        $response->assertSee('Quạt hộp');
        $response->assertSee('Quạt thông gió');
        $response->assertSee('Quạt công nghiệp');

        // 5. Khối B2B Hồ sơ cho đơn hàng doanh nghiệp (50/50)
        $response->assertSee('Hồ sơ cho đơn hàng');
        $response->assertSee('doanh nghiệp');
        $response->assertSee('Xem thông tin doanh nghiệp →', false);

        // 6. Sản phẩm nổi bật (5 cards)
        $response->assertSee('Sản phẩm nổi bật');

        // 7. Dải 4 thương hiệu liên tục (Vinawind, KOMASU, Chinghai, NANYOO)
        $response->assertSee('v8-brand-banner-strip', false);
        $response->assertSee('Vinawind');
        $response->assertSee('KOMASU');
        $response->assertSee('Chinghai');
        $response->assertSee('NANYOO');

        // 8. Sản phẩm vừa cập nhật
        $response->assertSee('Sản phẩm vừa cập nhật');

        // 9. 2 cột ngành hàng
        $response->assertSee('Quạt điện dân dụng');
        $response->assertSee('Quạt công nghiệp');

        // 10. Khối Giới thiệu & Uy tín
        $response->assertSee('Winline cung cấp quạt điện và thiết bị thông gió');
        $response->assertSee('Tìm hiểu về Winline →', false);
    }
}

