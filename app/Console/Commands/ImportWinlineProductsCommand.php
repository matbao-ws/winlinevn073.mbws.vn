<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Category;
use App\Models\LocalizedSlug;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\LocalizedSlugService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImportWinlineProductsCommand extends Command
{
    protected $signature = 'winline:import-products {--file= : Path to raw products JSON file} {--force : Overwrite existing products}';
    protected $description = 'Import 841 products from winline.vn raw JSON into products, brands, and categories';

    public function handle(LocalizedSlugService $slugService): int
    {
        $filePath = $this->option('file') ?: base_path('storage/app/winline_raw_products.json');
        
        if (! File::exists($filePath)) {
            $scratchPath = '/home/binhphan/.gemini/antigravity/brain/007e3fde-7f64-4321-8704-216868e9ad52/scratch/winline_raw_products.json';
            if (File::exists($scratchPath)) {
                $filePath = $scratchPath;
            } else {
                $this->error("Products JSON file not found at: {$filePath}");
                return self::FAILURE;
            }
        }

        $this->info("Loading raw products from: {$filePath}");
        $productsData = json_decode(File::get($filePath), true);

        if (! is_array($productsData)) {
            $this->error("Invalid JSON data in file.");
            return self::FAILURE;
        }

        $totalCount = count($productsData);
        $this->info("Found {$totalCount} products to process.");

        // Check gallery map if exists
        $galleryMap = [];
        $galleryMapPath = dirname($filePath) . '/gallery_map.json';
        if (File::exists($galleryMapPath)) {
            $galleryMap = json_decode(File::get($galleryMapPath), true) ?: [];
        }

        // Cache existing Brands
        $brandsCache = [];
        foreach (Brand::all() as $b) {
            $bName = strtolower(trim($b->getTranslation('name', 'vi') ?: $b->slug));
            $brandsCache[$bName] = $b;
            $brandsCache[strtolower($b->slug)] = $b;
        }

        $imported = 0;
        $updated = 0;
        $errors = 0;

        $bar = $this->output->createProgressBar($totalCount);
        $bar->start();

        foreach ($productsData as $raw) {
            try {
                $slug = trim($raw['alias'] ?? '');
                if (! $slug) {
                    $slug = Str::slug($raw['name'] ?? 'san-pham-' . ($raw['id'] ?? uniqid()));
                }

                $name = trim($raw['name'] ?? '');
                if (! $name) {
                    continue;
                }

                // 1. Resolve or create Brand
                $rawVendor = trim($raw['vendor'] ?? '');
                $brand = $this->resolveBrand($rawVendor, $name, $brandsCache, $slugService);

                // 2. Resolve Category
                $categoryId = $this->resolveCategoryId($raw);

                // 3. Extract HVAC Specs
                $specs = $this->extractSpecs($raw);

                // 4. SKU
                $sku = null;
                if (! empty($raw['variants'][0]['sku'])) {
                    $sku = trim($raw['variants'][0]['sku']);
                }
                if (! $sku) {
                    $sku = 'WL-' . ($raw['id'] ?? rand(100000, 999999));
                }

                // 5. Image URL
                $imageUrl = $this->resolveImageUrl($slug, $raw);

                // 6. Descriptions
                $content = $raw['content'] ?? '';
                $summary = trim(strip_tags($raw['summary'] ?? ''));
                if (! $summary) {
                    $summary = Str::limit(trim(strip_tags($content)), 220);
                }

                $metaTitle = $name . ' - Chính Hãng Giá Tốt | Winline';
                $metaDesc = Str::limit($summary, 160);

                // Prices
                $price = (float) ($raw['price'] ?? 0);
                $compareAtPrice = (float) ($raw['compare_at_price_min'] ?? 0);
                if ($compareAtPrice <= $price) {
                    $compareAtPrice = (float) ($raw['compare_at_price_max'] ?? 0);
                }
                if ($compareAtPrice <= $price) {
                    $compareAtPrice = 0;
                }

                // Find existing product strictly by slug (do not match by SKU to avoid merging distinct color products)
                $product = Product::where('slug', $slug)->first();

                // Ensure SKU is unique if another product already uses it
                $existingWithSku = Product::where('sku', $sku)->first();
                if ($existingWithSku && (! $product || $existingWithSku->id !== $product->id)) {
                    $sku = $sku . '-' . ($raw['id'] ?? Str::slug($slug));
                }

                $isNew = ! $product;
                if ($isNew) {
                    $product = new Product();
                    $product->slug = $slug;
                }

                $product->category_id = $categoryId;
                $product->brand_id = $brand ? $brand->id : null;
                $product->name = ['vi' => $name, 'en' => $name];
                $product->sku = $sku;
                $product->short_description = ['vi' => $summary, 'en' => $summary];
                $product->description = ['vi' => $content, 'en' => $content];
                $product->meta_title = ['vi' => $metaTitle, 'en' => $metaTitle];
                $product->meta_description = ['vi' => $metaDesc, 'en' => $metaDesc];
                $product->image_url = $imageUrl;
                $product->price = $price;
                $product->compare_at_price = $compareAtPrice;
                $product->stock_quantity = 100;
                $product->manage_stock = false;
                $product->is_active = true;
                $product->sort_order = 0;
                $product->published_at = $product->published_at ?: now();

                // HVAC specs
                if (! empty($specs['power'])) {
                    $product->power = $specs['power'];
                }
                if (! empty($specs['voltage'])) {
                    $product->voltage = $specs['voltage'];
                }
                if (! empty($specs['airflow'])) {
                    $product->airflow = $specs['airflow'];
                }
                if (! empty($specs['size_display'])) {
                    $product->size_display = $specs['size_display'];
                }

                $product->save();

                // 7. Sync LocalizedSlug
                $slugService->sync(
                    $product,
                    ['vi' => $product->slug, 'en' => $product->slug],
                    ['vi' => $name, 'en' => $name]
                );

                // 8. Gallery images
                $galleryPaths = $galleryMap[$slug] ?? [];
                if (! empty($galleryPaths)) {
                    ProductImage::where('product_id', $product->id)->delete();
                    foreach ($galleryPaths as $gIdx => $gPath) {
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_url' => $gPath,
                            'sort_order' => $gIdx + 1,
                        ]);
                    }
                }

                if ($isNew) {
                    $imported++;
                } else {
                    $updated++;
                }
            } catch (\Throwable $e) {
                $errors++;
                $this->error("Error importing {$raw['alias']}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Import completed successfully!");
        $this->table(
            ['Metric', 'Count'],
            [
                ['New Products Inserted', $imported],
                ['Existing Products Updated', $updated],
                ['Errors', $errors],
                ['Total Products Now in DB', Product::count()],
                ['Total Brands Now in DB', Brand::count()],
                ['Total Gallery Images in DB', ProductImage::count()],
                ['Total LocalizedSlugs in DB', LocalizedSlug::count()],
            ]
        );

        return self::SUCCESS;
    }

    private function resolveBrand(?string $rawVendor, string $productName, array &$cache, LocalizedSlugService $slugService): ?Brand
    {
        $rawVendor = trim($rawVendor ?? '');

        $normalizedMap = [
            'komasu' => 'Komasu',
            'hatari' => 'Hatari',
            'haiki' => 'Haiki',
            'superlite' => 'Superlite Max',
            'superlite max' => 'Superlite Max',
            'điện cơ 91' => 'Điện cơ 91',
            'bmf' => 'BMF',
            'gale' => 'Gale',
            'gcool' => 'Gcool',
            'kyungjin' => 'Kyungjin',
            'senko' => 'Senko',
            'nanyoo' => 'Nanyoo',
            'panasonic' => 'Panasonic',
            'mitsubishi' => 'Mitsubishi',
            'tico' => 'Tico',
            'chinghai' => 'Chinghai',
            'nedfon' => 'Nedfon',
            'deton' => 'Deton',
            'dasin' => 'Dasin',
            'kdk' => 'KDK',
            'ac' => 'AC',
            'dreamer' => 'Dreamer',
        ];

        if (! $rawVendor) {
            $lowerName = mb_strtolower($productName, 'UTF-8');
            foreach ($normalizedMap as $kw => $canonical) {
                if (str_contains($lowerName, $kw)) {
                    $rawVendor = $canonical;
                    break;
                }
            }
            if (! $rawVendor) {
                return null;
            }
        }

        $lowerKey = mb_strtolower($rawVendor, 'UTF-8');
        $canonicalName = $normalizedMap[$lowerKey] ?? ucwords($rawVendor);

        $lookupKey = mb_strtolower($canonicalName, 'UTF-8');
        if (isset($cache[$lookupKey])) {
            return $cache[$lookupKey];
        }

        $brand = Brand::whereRaw('LOWER(slug) = ?', [Str::slug($canonicalName)])->first();
        if (! $brand) {
            $brand = Brand::create([
                'name' => ['vi' => $canonicalName, 'en' => $canonicalName],
                'slug' => Str::slug($canonicalName),
                'description' => ['vi' => "Thương hiệu {$canonicalName} chính hãng phân phối tại Winline Việt Nam.", 'en' => "{$canonicalName} authentic products distributed by Winline Vietnam."],
                'image_url' => null,
                'sort_order' => 0,
                'is_active' => true,
            ]);

            $slugService->sync(
                $brand,
                ['vi' => $brand->slug, 'en' => $brand->slug],
                ['vi' => $canonicalName, 'en' => $canonicalName]
            );
        }

        $cache[$lookupKey] = $brand;
        $cache[strtolower($brand->slug)] = $brand;

        return $brand;
    }

    private function resolveCategoryId(array $p): int
    {
        $name = mb_strtolower($p['name'] ?? '', 'UTF-8');
        $alias = mb_strtolower($p['alias'] ?? '', 'UTF-8');
        $tags = array_map(fn($t) => mb_strtolower($t, 'UTF-8'), $p['tags'] ?? []);
        $tagStr = implode(' ', $tags);

        // 1. Quạt cắt gió (Air Curtain)
        if (str_contains($name, 'cắt gió') || str_contains($name, 'chắn gió') || str_contains($alias, 'cat-gio') || str_contains($tagStr, 'quạt cắt gió') || str_contains($tagStr, 'quạt chắn gió')) {
            return 22;
        }

        // 2. Cấp khí tươi / ERV / Thu hồi nhiệt / Bộ lọc
        if (str_contains($name, 'cấp khí tươi') || str_contains($name, 'thu hồi nhiệt') || str_contains($name, 'lọc không khí') || str_contains($name, 'erv') || str_contains($alias, 'cap-khi-tuoi') || str_contains($alias, 'bo-loc')) {
            return 23;
        }

        // 3. Cooling pad
        if (str_contains($name, 'cooling pad') || str_contains($name, 'tấm làm mát') || str_contains($name, 'khung tấm') || str_contains($alias, 'cooling-pad')) {
            return 7;
        }

        // 4. Điều hòa di động / Máy làm mát công nghiệp
        if (str_contains($name, 'điều hòa di động') || str_contains($name, 'máy làm mát') || str_contains($alias, 'dieu-hoa-di-dong')) {
            return 6;
        }

        // 5. Quạt ly tâm / Hút khói PCCC / Hút bếp
        if (str_contains($name, 'ly tâm') || str_contains($alias, 'ly-tam') || str_contains($name, 'hút bếp') || str_contains($name, 'chịu nhiệt') || str_contains($name, 'pccc')) {
            return 4;
        }

        // 6. Quạt hướng trục / Hút mái nhà xưởng
        if (str_contains($name, 'hướng trục') || str_contains($alias, 'huong-truc') || str_contains($name, 'hút mái') || str_contains($tagStr, 'quạt hướng trục')) {
            return 5;
        }

        // 7. Quạt hút xách tay / Di động
        if (str_contains($name, 'xách tay') || str_contains($name, 'di động') || str_contains($alias, 'xach-tay') || str_contains($alias, 'hut-di-dong')) {
            return 21;
        }

        // 8. Quạt công nghiệp vuông
        if ((str_contains($name, 'vuông') && (str_contains($name, 'công nghiệp') || str_contains($name, 'hút') || str_contains($name, 'thông gió'))) || str_contains($alias, 'vuong') || str_contains($tagStr, 'hút công nghiệp vuông')) {
            return 20;
        }

        // 9. Quạt thông gió công nghiệp tròn
        if ((str_contains($name, 'tròn') && (str_contains($name, 'công nghiệp') || str_contains($name, 'thông gió'))) || str_contains($tagStr, 'thông gió công nghiệp tròn')) {
            return 3;
        }

        // 10. Quạt cây công nghiệp / Quạt đứng công nghiệp
        if ((str_contains($name, 'cây') || str_contains($name, 'đứng')) && (str_contains($name, 'công nghiệp') || str_contains($name, 'cn') || str_contains($name, 'superlite') || str_contains($name, 'komasu') || str_contains($name, 'haiki') || str_contains($name, 'gale'))) {
            return 17;
        }
        if (str_contains($tagStr, 'quạt cây công nghiệp') || str_contains($tagStr, 'quạt đứng công nghiệp')) {
            return 17;
        }

        // 11. Quạt treo tường công nghiệp
        if (str_contains($name, 'treo') && (str_contains($name, 'công nghiệp') || str_contains($name, 'cn') || str_contains($name, 'superlite') || str_contains($name, 'haiki') || str_contains($name, 'gale'))) {
            return 18;
        }
        if (str_contains($tagStr, 'treo tường công nghiệp') || str_contains($tagStr, 'treo công nghiệp')) {
            return 18;
        }

        // 12. Quạt sàn công nghiệp
        if (str_contains($name, 'sàn') && (str_contains($name, 'công nghiệp') || str_contains($name, 'cn') || str_contains($name, 'chân quỳ') || str_contains($name, 'komasu') || str_contains($name, 'haiki') || str_contains($name, 'dasin'))) {
            return 19;
        }
        if (str_contains($tagStr, 'quạt sàn công nghiệp')) {
            return 19;
        }

        // 13. Quạt trần
        if (str_contains($name, 'trần') && (! str_contains($name, 'hút') && ! str_contains($name, 'thông gió') && ! str_contains($name, 'đảo'))) {
            return 10;
        }
        if (str_contains($tagStr, 'quạt trần') && ! str_contains($tagStr, 'đảo trần')) {
            return 10;
        }

        // 14. Quạt đảo trần
        if (str_contains($name, 'đảo trần') || str_contains($name, 'đảo') || str_contains($alias, 'dao-tran') || str_contains($tagStr, 'quạt đảo')) {
            return 13;
        }

        // 15. Quạt cây dân dụng / Quạt lửng
        if (str_contains($name, 'cây') || str_contains($name, 'đứng') || str_contains($name, 'lửng') || str_contains($tagStr, 'quạt cây')) {
            return 11;
        }

        // 16. Quạt treo tường dân dụng
        if (str_contains($name, 'treo tường') || str_contains($name, 'treo') || str_contains($alias, 'treo-tuong') || str_contains($tagStr, 'quạt treo')) {
            return 12;
        }

        // 17. Quạt hộp & Quạt bàn
        if (str_contains($name, 'hộp') || str_contains($name, 'bàn') || str_contains($name, 'tản') || str_contains($alias, 'hop') || str_contains($alias, 'ban') || str_contains($tagStr, 'quạt hộp') || str_contains($tagStr, 'quạt bàn')) {
            return 14;
        }

        // 18. Quạt sàn chân quỳ dân dụng
        if (str_contains($name, 'sàn') || str_contains($name, 'quỳ') || str_contains($alias, 'san') || str_contains($tagStr, 'quạt sàn')) {
            return 15;
        }

        // 19. Ống gió & Phụ kiện
        if (str_contains($name, 'ống gió') || str_contains($name, 'nối ống') || str_contains($name, 'cabinet') || str_contains($name, 'cửa gió') || str_contains($name, 'điều khiển') || str_contains($name, 'khung') || str_contains($alias, 'ong-gio') || str_contains($tagStr, 'nối ống')) {
            return 24;
        }

        // 20. Quạt thông gió dân dụng / Hút âm trần
        if (str_contains($name, 'thông gió') || str_contains($name, 'hút âm trần') || str_contains($name, 'hút mùi') || str_contains($name, 'hút gió') || str_contains($tagStr, 'thông gió') || str_contains($tagStr, 'hút âm trần')) {
            return 16;
        }

        // 21. Máy hút ẩm -> Thông gió & Làm mát
        if (str_contains($name, 'hút ẩm')) {
            return 9;
        }

        return 1;
    }

    private function extractSpecs(array $raw): array
    {
        $name = $raw['name'] ?? '';
        $content = $raw['content'] ?? '';
        $text = $name . ' ' . strip_tags($content);

        // Power
        $power = null;
        if (preg_match('/(?:công suất|power)[^\d]{0,10}(\d+(?:[\.,]\d+)?\s*(?:kW|W))/iu', $text, $m)) {
            $power = trim($m[1]);
        } elseif (preg_match('/(\d+(?:[\.,]\d+)?\s*(?:kW|W))/iu', $name, $m)) {
            $power = trim($m[1]);
        }

        // Voltage
        $voltage = null;
        if (preg_match('/380\s*V|3\s*pha/i', $text)) {
            $voltage = '380V / 3 pha';
        } elseif (preg_match('/220\s*V|1\s*pha/i', $text)) {
            $voltage = '220V / 50Hz';
        }

        // Airflow
        $airflow = null;
        if (preg_match('/(?:lưu lượng gió|lưu lượng|airflow)[^\d]{0,10}(\d[\d\.,]*)\s*(?:m3\/h|m³\/h)/iu', $text, $m)) {
            $val = str_replace(['.', ','], '', $m[1]);
            if (is_numeric($val) && (int) $val > 0) {
                $airflow = (int) $val;
            }
        }

        // Size display
        $size = null;
        if (preg_match('/(\d{3,4}\s*[xX*]\s*\d{3,4}(?:\s*[xX*]\s*\d{2,4})?\s*(?:mm)?)/u', $name, $m)) {
            $size = trim($m[1]);
        } elseif (preg_match('/(?:sải cánh|đường kính cánh)[^\d]{0,10}(\d+(?:[\.,]\d+)?\s*(?:mm|cm|m))/iu', $text, $m)) {
            $size = trim($m[1]);
        }

        return [
            'power' => $power,
            'voltage' => $voltage,
            'airflow' => $airflow,
            'size_display' => $size,
        ];
    }

    private function resolveImageUrl(string $slug, array $raw): string
    {
        $dir = public_path('client-assets/images/products');
        foreach (['.jpg', '.png', '.jpeg', '.webp'] as $ext) {
            $filename = "{$slug}{$ext}";
            if (File::exists("{$dir}/{$filename}")) {
                return "/client-assets/images/products/{$filename}";
            }
        }

        $feat = $raw['featured_image'] ?? ($raw['images'][0] ?? null);
        if ($feat) {
            return $feat;
        }

        return '/client-assets/images/placeholder.png';
    }
}
