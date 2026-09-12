<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ModelComparisonItem;
use App\Models\ModelComparisonTable;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Database\Seeder;

class NanyooModelComparisonTableSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tìm hoặc tạo Danh mục Quạt cắt gió
        $category = Category::query()->where('slug', 'quat-cat-gio')->first();
        if (!$category) {
            $category = Category::query()->firstOrCreate(
                ['slug' => 'quat-cat-gio-nanyoo'],
                [
                    'name' => ['vi' => 'Quạt cắt gió Nanyoo', 'en' => 'Nanyoo Air Curtains'],
                    'description' => ['vi' => 'Dòng quạt cắt gió chắn bụi, ngăn lạnh chuyên dụng công nghiệp và thương mại.'],
                    'is_active' => true,
                ]
            );
        }

        // 2. Tạo Bảng So Sánh Model Nanyoo-Z
        $table = ModelComparisonTable::firstOrCreate(
            ['name' => 'Bảng quạt cắt gió Nanyoo-Z (Cửa < 5.5m)'],
            [
                'title' => 'Quạt cắt gió Nanyoo-Z Được đề xuất cho cửa cao dưới 5.5m',
                'subtitle' => 'Bảng so sánh kích thước, lưu lượng gió và công suất các model dòng Z',
                'columns' => [
                    'Điện áp (V/Hz)',
                    'Công suất (W)',
                    'Lưu lượng gió (m³/h)',
                    'Vận tốc gió (m/s)',
                    'Độ ồn (dB)',
                    'Số Động cơ (Cái)',
                    'Kích thước quạt (mm)',
                    'Cân nặng (kg - net)',
                ],
                'show_price' => true,
                'show_action_btn' => true,
                'is_active' => true,
            ]
        );

        // 3. Dữ liệu 6 Model Chuẩn 100% theo Ảnh mẫu của Khách
        $modelsData = [
            [
                'model' => 'FM-5509Z-L/Y',
                'name' => 'Quạt cắt gió Nanyoo FM-5509Z-L/Y (Dài 0.9m)',
                'slug' => 'quat-cat-gio-nanyoo-fm-5509z-l-y',
                'price' => 3850000,
                'compare_at_price' => 4200000,
                'specs' => [
                    'Điện áp (V/Hz)' => '220V/50Hz',
                    'Công suất (W)' => '420',
                    'Lưu lượng gió (m³/h)' => '1450',
                    'Vận tốc gió (m/s)' => '20',
                    'Độ ồn (dB)' => '< 48',
                    'Số Động cơ (Cái)' => '2',
                    'Kích thước quạt (mm)' => '900*230*215',
                    'Cân nặng (kg - net)' => '17.5',
                ],
            ],
            [
                'model' => 'FM-5510Z-L/Y',
                'name' => 'Quạt cắt gió Nanyoo FM-5510Z-L/Y (Dài 1.0m)',
                'slug' => 'quat-cat-gio-nanyoo-fm-5510z-l-y',
                'price' => 4350000,
                'compare_at_price' => 4700000,
                'specs' => [
                    'Điện áp (V/Hz)' => '220V/50Hz',
                    'Công suất (W)' => '420',
                    'Lưu lượng gió (m³/h)' => '1450',
                    'Vận tốc gió (m/s)' => '20',
                    'Độ ồn (dB)' => '< 48',
                    'Số Động cơ (Cái)' => '2',
                    'Kích thước quạt (mm)' => '1000*230*215',
                    'Cân nặng (kg - net)' => '18',
                ],
            ],
            [
                'model' => 'FM-5512Z-L/Y',
                'name' => 'Quạt cắt gió Nanyoo FM-5512Z-L/Y (Dài 1.2m)',
                'slug' => 'quat-cat-gio-nanyoo-fm-5512z-l-y',
                'price' => 4950000,
                'compare_at_price' => 5400000,
                'specs' => [
                    'Điện áp (V/Hz)' => '220V/50Hz',
                    'Công suất (W)' => '560',
                    'Lưu lượng gió (m³/h)' => '1930',
                    'Vận tốc gió (m/s)' => '20',
                    'Độ ồn (dB)' => '< 49',
                    'Số Động cơ (Cái)' => '2',
                    'Kích thước quạt (mm)' => '1200*230*215',
                    'Cân nặng (kg - net)' => '18.8',
                ],
            ],
            [
                'model' => 'FM-5515Z-L/Y',
                'name' => 'Quạt cắt gió Nanyoo FM-5515Z-L/Y (Dài 1.5m)',
                'slug' => 'quat-cat-gio-nanyoo-fm-5515z-l-y',
                'price' => 5850000,
                'compare_at_price' => 6300000,
                'specs' => [
                    'Điện áp (V/Hz)' => '220V/50Hz',
                    'Công suất (W)' => '700',
                    'Lưu lượng gió (m³/h)' => '2420',
                    'Vận tốc gió (m/s)' => '20',
                    'Độ ồn (dB)' => '< 52',
                    'Số Động cơ (Cái)' => '3',
                    'Kích thước quạt (mm)' => '1500*230*215',
                    'Cân nặng (kg - net)' => '25',
                ],
            ],
            [
                'model' => 'FM-5518Z-L/Y',
                'name' => 'Quạt cắt gió Nanyoo FM-5518Z-L/Y (Dài 1.8m)',
                'slug' => 'quat-cat-gio-nanyoo-fm-5518z-l-y',
                'price' => 6750000,
                'compare_at_price' => 7200000,
                'specs' => [
                    'Điện áp (V/Hz)' => '220V/50Hz',
                    'Công suất (W)' => '800',
                    'Lưu lượng gió (m³/h)' => '2900',
                    'Vận tốc gió (m/s)' => '20',
                    'Độ ồn (dB)' => '< 54',
                    'Số Động cơ (Cái)' => '3',
                    'Kích thước quạt (mm)' => '1800*230*215',
                    'Cân nặng (kg - net)' => '27.5',
                ],
            ],
            [
                'model' => 'FM-5520Z-L/Y',
                'name' => 'Quạt cắt gió Nanyoo FM-5520Z-L/Y (Dài 2.0m)',
                'slug' => 'quat-cat-gio-nanyoo-fm-5520z-l-y-dai-2-0m-cua-3-5m-5-5m',
                'price' => 7650000,
                'compare_at_price' => 8200000,
                'specs' => [
                    'Điện áp (V/Hz)' => '220V/50Hz',
                    'Công suất (W)' => '800',
                    'Lưu lượng gió (m³/h)' => '2900',
                    'Vận tốc gió (m/s)' => '20',
                    'Độ ồn (dB)' => '< 54',
                    'Số Động cơ (Cái)' => '3',
                    'Kích thước quạt (mm)' => '2000*230*215',
                    'Cân nặng (kg - net)' => '30',
                ],
            ],
        ];

        // 4. Tạo hoặc cập nhật Product và Item
        $table->items()->delete();

        foreach ($modelsData as $index => $itemData) {
            // Tìm hoặc tạo sản phẩm
            $product = Product::query()->where('sku', $itemData['model'])->first();
            if (!$product) {
                $product = Product::query()->where('slug', $itemData['slug'])->first();
            }

            if (!$product) {
                $product = Product::create([
                    'category_id' => $category->id,
                    'name' => ['vi' => $itemData['name']],
                    'slug' => $itemData['slug'],
                    'sku' => $itemData['model'],
                    'price' => $itemData['price'],
                    'compare_at_price' => $itemData['compare_at_price'],
                    'short_description' => [
                        'vi' => 'Dòng quạt cắt gió Nanyoo series Z công suất lớn, vận tốc gió 20m/s, chuyên dùng cho cửa cao đến 5.5m.',
                    ],
                    'description' => [
                        'vi' => "<p><strong>Đặc điểm nổi bật quạt cắt gió Nanyoo {$itemData['model']}:</strong></p><ul><li>Được thiết kế lấy khí từ phía trên, có thể điều chỉnh hướng lấy gió và áp suất.</li><li>Điều chỉnh được tốc độ gió theo ý muốn.</li><li>Được đánh giá có độ bền cao, dễ dàng lắp đặt, dễ dàng sử dụng.</li><li>Chi phí phải chăng, phù hợp với nhiều đối tượng khách hàng.</li><li>Có điều khiển từ xa và công tắc.</li><li>Xuất xứ: Trung quốc.</li><li>Bảo hành 12 tháng (2 năm với động cơ).</li></ul>",
                    ],
                    'image_url' => '/client-assets/images/placeholder.png',
                    'is_active' => true,
                    'is_featured' => true,
                    'model_comparison_table_id' => $table->id,
                ]);
            } else {
                $product->update([
                    'model_comparison_table_id' => $table->id,
                ]);
            }

            // Tạo dòng Item trong bảng
            ModelComparisonItem::create([
                'table_id' => $table->id,
                'product_id' => $product->id,
                'model_name' => $itemData['model'],
                'specs' => $itemData['specs'],
                'sort_order' => $index,
            ]);
        }

        // 5. Thử chèn vào 1 bài viết tin tức nếu có
        $samplePost = Post::query()->where('is_active', true)->first();
        if ($samplePost && !str_contains((string)$samplePost->content, 'bang_so_sanh')) {
            $currentContent = $samplePost->getTranslation('content', 'vi', false) ?: $samplePost->content;
            $updatedContent = $currentContent . "\n\n<h3>Bảng so sánh thông số các model quạt cắt gió Nanyoo-Z:</h3>\n<p>[bang_so_sanh id=\"{$table->id}\"]</p>";
            $samplePost->setTranslation('content', 'vi', $updatedContent);
            $samplePost->save();
        }
    }
}
