<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProjectSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchemaStructuredDataTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        ProjectSetting::updateOrCreate(
            ['setting_key' => 'site_name'],
            ['setting_value' => 'Winline Việt Nam', 'updated_at' => now()]
        );
        ProjectSetting::updateOrCreate(
            ['setting_key' => 'company_name'],
            ['setting_value' => 'Công ty TNHH Winline Việt Nam', 'updated_at' => now()]
        );
        ProjectSetting::updateOrCreate(
            ['setting_key' => 'hotline'],
            ['setting_value' => '0949.761.893', 'updated_at' => now()]
        );
        ProjectSetting::updateOrCreate(
            ['setting_key' => 'email'],
            ['setting_value' => 'Winlinevietnam@gmail.com', 'updated_at' => now()]
        );
    }

    public function test_homepage_renders_organization_and_website_schema(): void
    {
        $response = $this->get('/vi');
        $response->assertOk();

        $content = $response->getContent();
        $this->assertStringContainsString('application/ld+json', $content);
        $this->assertStringContainsString('"@type": "Organization"', $content);
        $this->assertStringContainsString('"@type": "WebSite"', $content);
        $this->assertStringContainsString('Winline Việt Nam', $content);
        $this->assertStringContainsString('SearchAction', $content);

        // Verify valid JSON
        preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $content, $matches);
        $this->assertNotEmpty($matches[1]);
        foreach ($matches[1] as $jsonString) {
            $decoded = json_decode(trim($jsonString), true);
            $this->assertNotNull($decoded, 'JSON-LD syntax error on homepage');
        }
    }

    public function test_category_page_renders_breadcrumbs_and_collection_schema(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => 'quat-cat-gio'],
            [
                'name' => ['vi' => 'Quạt cắt gió Air Curtain', 'en' => 'Air Curtain'],
                'is_active' => true,
            ]
        );

        $response = $this->get('/vi/quat-cat-gio');
        $response->assertOk();

        $content = $response->getContent();
        $this->assertStringContainsString('application/ld+json', $content);
        $this->assertStringContainsString('"@type": "BreadcrumbList"', $content);
        $this->assertStringContainsString('"@type": "CollectionPage"', $content);
        $this->assertStringContainsString('Quạt cắt gió', $content);

        // Verify valid JSON
        preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $content, $matches);
        $this->assertNotEmpty($matches[1]);
        foreach ($matches[1] as $jsonString) {
            $decoded = json_decode(trim($jsonString), true);
            $this->assertNotNull($decoded, 'JSON-LD syntax error on category page');
        }
    }

    public function test_nanyoo_product_page_renders_product_and_offer_schema(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => 'quat-cat-gio'],
            [
                'name' => ['vi' => 'Quạt cắt gió Air Curtain', 'en' => 'Air Curtain'],
                'is_active' => true,
            ]
        );

        $brand = Brand::firstOrCreate(
            ['slug' => 'nanyoo'],
            [
                'name' => ['vi' => 'Nanyoo', 'en' => 'Nanyoo'],
                'is_active' => true,
            ]
        );

        $product = Product::firstOrCreate(
            ['slug' => 'quat-cat-gio-nanyoo-fm-5509z-l-y'],
            [
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'name' => ['vi' => 'Quạt cắt gió Nanyoo FM-5509Z-L/Y (Dài 0.9m)', 'en' => 'Air Curtain Nanyoo FM-5509Z-L/Y'],
                'sku' => 'FM-5509Z-L/Y',
                'price' => 3850000,
                'compare_at_price' => 4200000,
                'stock_quantity' => 10,
                'manage_stock' => true,
                'is_active' => true,
                'short_description' => ['vi' => 'Dòng quạt cắt gió Nanyoo series Z công suất lớn', 'en' => 'Nanyoo series Z'],
            ]
        );

        $response = $this->get('/vi/san-pham/quat-cat-gio-nanyoo-fm-5509z-l-y');
        $response->assertOk();

        $content = $response->getContent();
        $this->assertStringContainsString('application/ld+json', $content);
        $this->assertStringContainsString('"@type": "Product"', $content);
        $this->assertStringContainsString('"@type": "Offer"', $content);
        $this->assertStringContainsString('"@type": "BreadcrumbList"', $content);
        $this->assertStringContainsString('FM-5509Z-L/Y', $content);
        $this->assertStringContainsString('"priceCurrency": "VND"', $content);
        $this->assertStringContainsString('"price": "3850000"', $content);
        $this->assertStringContainsString('Nanyoo', $content);

        // Verify valid JSON
        preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $content, $matches);
        $this->assertNotEmpty($matches[1]);
        foreach ($matches[1] as $jsonString) {
            $decoded = json_decode(trim($jsonString), true);
            $this->assertNotNull($decoded, 'JSON-LD syntax error on product page');
            if (isset($decoded['@type']) && $decoded['@type'] === 'Product') {
                $this->assertSame('FM-5509Z-L/Y', $decoded['sku']);
                $this->assertSame('3850000', $decoded['offers']['price']);
                $this->assertSame('VND', $decoded['offers']['priceCurrency']);
                $this->assertSame('Nanyoo', $decoded['brand']['name']);
            }
        }
    }

    public function test_news_article_renders_news_article_schema(): void
    {
        $postCat = PostCategory::firstOrCreate(
            ['slug' => 'tu-van-ky-thuat'],
            [
                'name' => 'Tư vấn kỹ thuật',
                'is_active' => true,
            ]
        );

        $post = Post::firstOrCreate(
            ['slug' => 'cach-tinh-luu-luong-gio'],
            [
                'category_id' => $postCat->id,
                'title' => ['vi' => 'Cách tính toán lưu lượng gió Q = V x T', 'en' => 'HVAC Calculation'],
                'summary' => ['vi' => 'Hướng dẫn chi tiết công thức chuẩn HVAC', 'en' => 'Summary'],
                'content' => ['vi' => '<p>Nội dung chi tiết...</p>', 'en' => '<p>Content</p>'],
                'is_active' => true,
                'published_at' => now(),
            ]
        );

        $response = $this->get('/vi/tin-tuc/cach-tinh-luu-luong-gio');
        $response->assertOk();

        $content = $response->getContent();
        $this->assertStringContainsString('application/ld+json', $content);
        $this->assertStringContainsString('"@type": "NewsArticle"', $content);
        $this->assertStringContainsString('"@type": "BreadcrumbList"', $content);
        $this->assertStringContainsString('Ban biên tập Winline Việt Nam', $content);

        // Verify valid JSON
        preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $content, $matches);
        $this->assertNotEmpty($matches[1]);
        foreach ($matches[1] as $jsonString) {
            $decoded = json_decode(trim($jsonString), true);
            $this->assertNotNull($decoded, 'JSON-LD syntax error on news article page');
        }
    }
}
