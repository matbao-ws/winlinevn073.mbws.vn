<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\FeatureSetting;
use App\Models\ModelComparisonItem;
use App\Models\ModelComparisonTable;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\User;
use App\Services\ContentRenderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelComparisonTableTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        FeatureSetting::query()->create([
            'feature_code' => 'catalog',
            'is_enabled' => true,
        ]);
        FeatureSetting::query()->create([
            'feature_code' => 'cms_page',
            'is_enabled' => true,
        ]);
    }

    public function test_admin_can_access_model_tables_screens(): void
    {
        $user = User::factory()->create();

        $table = ModelComparisonTable::create([
            'name' => 'Bảng quạt cắt gió test',
            'title' => 'Quạt cắt gió Nanyoo-Z cửa dưới 5.5m',
            'columns' => ['Điện áp (V/Hz)', 'Công suất (W)'],
            'show_price' => true,
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->get('/vi/admin/model-tables')
            ->assertOk()
            ->assertSee('Bảng so sánh model sản phẩm')
            ->assertSee('Bảng quạt cắt gió test');

        $this->actingAs($user)
            ->get('/vi/admin/model-tables/create')
            ->assertOk()
            ->assertSee('Thêm Bảng So Sánh Model');

        $this->actingAs($user)
            ->get("/vi/admin/model-tables/{$table->id}/edit")
            ->assertOk()
            ->assertSee('Chỉnh Sửa Bảng So Sánh Model');
    }

    public function test_admin_can_store_update_and_duplicate_model_table(): void
    {
        $user = User::factory()->create();

        $category = Category::create([
            'name' => ['vi' => 'Quạt test ' . uniqid()],
            'slug' => 'quat-test-' . uniqid(),
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => ['vi' => 'Quạt cắt gió FM-5509Z-L/Y'],
            'slug' => 'quat-cat-gio-fm-5509z-l-y-' . uniqid(),
            'sku' => 'FM-5509Z-L/Y',
            'price' => 3500000,
            'is_active' => true,
        ]);

        // 1. Store
        $response = $this->actingAs($user)
            ->post('/vi/admin/model-tables', [
                'name' => 'Bảng Nanyoo Z',
                'title' => 'Quạt cắt gió Nanyoo-Z Được đề xuất cho cửa cao dưới 5.5m',
                'subtitle' => 'Bảng chọn model theo công suất',
                'columns' => ['Điện áp (V/Hz)', 'Công suất (W)', 'Lưu lượng gió (m³/h)'],
                'show_price' => '1',
                'show_action_btn' => '1',
                'is_active' => '1',
                'items' => [
                    'row_0' => [
                        'product_id' => $product->id,
                        'model_name' => 'FM-5509Z-L/Y',
                        'specs' => [
                            'Điện áp (V/Hz)' => '220V/50Hz',
                            'Công suất (W)' => '420',
                            'Lưu lượng gió (m³/h)' => '1450',
                        ],
                    ],
                ],
            ]);

        $response->assertRedirect('/vi/admin/model-tables');

        $table = ModelComparisonTable::first();
        $this->assertNotNull($table);
        $this->assertSame('Bảng Nanyoo Z', $table->name);
        $this->assertCount(1, $table->items);
        $this->assertSame('FM-5509Z-L/Y', $table->items->first()->model_name);
        $this->assertSame('420', $table->items->first()->specs['Công suất (W)']);

        // 2. Update
        $this->actingAs($user)
            ->put("/vi/admin/model-tables/{$table->id}", [
                'name' => 'Bảng Nanyoo Z Cập nhật',
                'title' => $table->title,
                'columns' => ['Điện áp (V/Hz)', 'Công suất (W)'],
                'show_price' => '1',
                'show_action_btn' => '1',
                'is_active' => '1',
                'items' => [
                    'row_0' => [
                        'product_id' => $product->id,
                        'model_name' => 'FM-5509Z-L/Y Updated',
                        'specs' => [
                            'Điện áp (V/Hz)' => '220V/50Hz',
                            'Công suất (W)' => '450',
                        ],
                    ],
                ],
            ])
            ->assertRedirect('/vi/admin/model-tables');

        $table->refresh();
        $this->assertSame('Bảng Nanyoo Z Cập nhật', $table->name);
        $this->assertSame('FM-5509Z-L/Y Updated', $table->items->first()->model_name);
        $this->assertSame('450', $table->items->first()->specs['Công suất (W)']);

        // 3. Duplicate
        $this->actingAs($user)
            ->post("/vi/admin/model-tables/{$table->id}/duplicate")
            ->assertRedirect('/vi/admin/model-tables');

        $this->assertDatabaseCount('model_comparison_tables', 2);
    }

    public function test_shortcode_parsing_and_realtime_price(): void
    {
        $category = Category::create([
            'name' => ['vi' => 'Quạt test ' . uniqid()],
            'slug' => 'quat-test-' . uniqid(),
            'is_active' => true,
        ]);

        $productSlug = 'quat-nanyoo-fm-5509z-' . uniqid();
        $product = Product::create([
            'category_id' => $category->id,
            'name' => ['vi' => 'Quạt cắt gió Nanyoo FM-5509Z-L/Y'],
            'slug' => $productSlug,
            'sku' => 'FM-5509Z-L/Y',
            'price' => 3200000,
            'is_active' => true,
        ]);

        $table = ModelComparisonTable::create([
            'name' => 'Bảng Nanyoo',
            'title' => 'Quạt cắt gió Nanyoo-Z Được đề xuất cho cửa cao dưới 5.5m',
            'columns' => ['Điện áp (V/Hz)', 'Công suất (W)', 'Lưu lượng gió (m³/h)'],
            'show_price' => true,
            'show_action_btn' => true,
            'is_active' => true,
        ]);

        ModelComparisonItem::create([
            'table_id' => $table->id,
            'product_id' => $product->id,
            'model_name' => 'FM-5509Z-L/Y',
            'specs' => [
                'Điện áp (V/Hz)' => '220V/50Hz',
                'Công suất (W)' => '420',
                'Lưu lượng gió (m³/h)' => '1450',
            ],
            'sort_order' => 0,
        ]);

        $service = app(ContentRenderService::class);

        // Render shortcode inside HTML paragraph
        $content = '<p>Dưới đây là bảng thông số so sánh:</p><p>[bang_so_sanh id="' . $table->id . '"]</p><p>Liên hệ để đặt hàng.</p>';
        $rendered = $service->render($content, null, 'vi');

        // Check rendered HTML
        $this->assertStringContainsString('Quạt cắt gió Nanyoo-Z Được đề xuất cho cửa cao dưới 5.5m', $rendered);
        $this->assertStringContainsString('FM-5509Z-L/Y', $rendered);
        $this->assertStringContainsString('3.200.000 đ', $rendered);
        $this->assertStringContainsString('420', $rendered);
        $this->assertStringContainsString('1450', $rendered);
        $this->assertStringContainsString($productSlug, $rendered);

        // Test Real-time price: update product price in DB
        $product->update(['price' => 4500000]);

        $renderedAfterPriceChange = $service->render($content, null, 'vi');
        $this->assertStringContainsString('4.500.000 đ', $renderedAfterPriceChange);
        $this->assertStringNotContainsString('3.200.000 đ', $renderedAfterPriceChange);
    }

    public function test_client_product_detail_renders_attached_table_and_active_highlight(): void
    {
        $category = Category::create([
            'name' => ['vi' => 'Quạt test ' . uniqid()],
            'slug' => 'quat-test-' . uniqid(),
            'is_active' => true,
        ]);

        $table = ModelComparisonTable::create([
            'name' => 'Bảng Nanyoo',
            'title' => 'Quạt cắt gió Nanyoo-Z Được đề xuất cho cửa cao dưới 5.5m',
            'columns' => ['Điện áp (V/Hz)', 'Công suất (W)'],
            'show_price' => true,
            'is_active' => true,
        ]);

        $slug1 = 'quat-cat-gio-fm-5509z-' . uniqid();
        $product1 = Product::create([
            'category_id' => $category->id,
            'name' => ['vi' => 'Quạt cắt gió FM-5509Z'],
            'slug' => $slug1,
            'sku' => 'FM-5509Z',
            'price' => 3000000,
            'is_active' => true,
            'model_comparison_table_id' => $table->id,
        ]);

        $slug2 = 'quat-cat-gio-fm-5510z-' . uniqid();
        $product2 = Product::create([
            'category_id' => $category->id,
            'name' => ['vi' => 'Quạt cắt gió FM-5510Z'],
            'slug' => $slug2,
            'sku' => 'FM-5510Z',
            'price' => 3500000,
            'is_active' => true,
            'model_comparison_table_id' => $table->id,
        ]);

        ModelComparisonItem::create([
            'table_id' => $table->id,
            'product_id' => $product1->id,
            'model_name' => 'FM-5509Z',
            'specs' => ['Điện áp (V/Hz)' => '220V', 'Công suất (W)' => '420'],
            'sort_order' => 0,
        ]);

        ModelComparisonItem::create([
            'table_id' => $table->id,
            'product_id' => $product2->id,
            'model_name' => 'FM-5510Z',
            'specs' => ['Điện áp (V/Hz)' => '220V', 'Công suất (W)' => '560'],
            'sort_order' => 1,
        ]);

        $response = $this->get("/vi/san-pham/{$slug1}");
        $response->assertOk();
        $response->assertSee('Quạt cắt gió Nanyoo-Z Được đề xuất cho cửa cao dưới 5.5m');
        $response->assertSee('FM-5509Z');
        $response->assertSee('FM-5510Z');
        $response->assertSee('Đang xem');
    }

    public function test_client_news_detail_renders_comparison_table_shortcode(): void
    {
        $table = ModelComparisonTable::create([
            'name' => 'Bảng Nanyoo',
            'title' => 'Bảng thông số so sánh quạt Nanyoo',
            'columns' => ['Công suất (W)'],
            'show_price' => true,
            'is_active' => true,
        ]);

        ModelComparisonItem::create([
            'table_id' => $table->id,
            'model_name' => 'Model-X',
            'specs' => ['Công suất (W)' => '800'],
            'custom_price' => 2500000,
            'sort_order' => 0,
        ]);

        $cat = PostCategory::create([
            'name' => ['vi' => 'Tư vấn kỹ thuật'],
            'slug' => 'tu-van-ky-thuat-' . uniqid(),
            'is_active' => true,
        ]);

        $postSlug = 'huong-dan-chon-mua-quat-cat-gio-' . uniqid();
        $post = Post::create([
            'category_id' => $cat->id,
            'title' => ['vi' => 'Hướng dẫn chọn mua quạt cắt gió chuẩn nhất'],
            'slug' => $postSlug,
            'summary' => ['vi' => 'Tóm tắt bài viết'],
            'content' => ['vi' => '<p>Tham khảo bảng sau:</p><p>[bang_so_sanh id="' . $table->id . '"]</p>'],
            'is_active' => true,
            'published_at' => now(),
        ]);

        $response = $this->get("/vi/tin-tuc/{$postSlug}");
        $response->assertOk();
        $response->assertSee('Bảng thông số so sánh quạt Nanyoo');
        $response->assertSee('Model-X');
        $response->assertSee('800');
        $response->assertSee('2.500.000 đ');
    }
}
