<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FanProductsSeeder extends Seeder
{
    public function run(): void
    {
        $komasu = Brand::firstOrCreate(['slug' => 'komasu'], ['name' => 'Komasu', 'is_active' => true, 'sort_order' => 1]);
        $deton = Brand::firstOrCreate(['slug' => 'deton'], ['name' => 'Deton', 'is_active' => true, 'sort_order' => 2]);
        $dasin = Brand::firstOrCreate(['slug' => 'dasin'], ['name' => 'Dasin', 'is_active' => true, 'sort_order' => 3]);
        $vinawind = Brand::firstOrCreate(['slug' => 'vinawind'], ['name' => 'Vinawind', 'is_active' => true, 'sort_order' => 4]);
        $nedfon = Brand::firstOrCreate(['slug' => 'nedfon'], ['name' => 'Nedfon', 'is_active' => true, 'sort_order' => 5]);
        $panasonic = Brand::firstOrCreate(['slug' => 'panasonic'], ['name' => 'Panasonic', 'is_active' => true, 'sort_order' => 6]);
        $kdk = Brand::firstOrCreate(['slug' => 'kdk'], ['name' => 'KDK', 'is_active' => true, 'sort_order' => 7]);

        $catSquare = Category::firstOrCreate(['slug' => 'quat-thong-gio-cong-nghiep'], [
            'name' => ['vi' => 'Quạt thông gió công nghiệp', 'en' => 'Industrial Exhaust Fans'],
            'is_active' => true,
            'sort_order' => 3,
        ]);
        $catCentrifugal = Category::firstOrCreate(['slug' => 'quat-ly-tam'], [
            'name' => ['vi' => 'Quạt ly tâm', 'en' => 'Centrifugal Fans'],
            'is_active' => true,
            'sort_order' => 4,
        ]);
        $catAxial = Category::firstOrCreate(['slug' => 'quat-huong-truc'], [
            'name' => ['vi' => 'Quạt hướng trục', 'en' => 'Axial Fans'],
            'is_active' => true,
            'sort_order' => 5,
        ]);
        $catCoolingPad = Category::firstOrCreate(['slug' => 'tam-lam-mat-cooling-pad'], [
            'name' => ['vi' => 'Tấm làm mát Cooling Pad', 'en' => 'Cooling Pads'],
            'is_active' => true,
            'sort_order' => 7,
        ]);
        $catDuct = Category::firstOrCreate(['slug' => 'he-thong-thong-gio-lam-mat'], [
            'name' => ['vi' => 'Hệ thống thông gió & làm mát', 'en' => 'Ventilation & Cooling Systems'],
            'is_active' => true,
            'sort_order' => 9,
        ]);

        // Update existing products
        Product::where('sku', 'KM-VUONG-1380')->update([
            'airflow' => 44500,
            'power' => '1.1 kW',
            'voltage' => '380V',
            'size_display' => '1380x1380x400 mm',
            'hole_size' => '1380x1380',
            'fan_type' => 'Quạt thông gió vuông',
            'use_ventilation' => true,
            'use_cooling_pad' => true,
        ]);

        Product::where('sku', 'DETON-FAG1380')->update([
            'airflow' => 44000,
            'power' => '1.1 kW',
            'voltage' => '380V',
            'size_display' => '1380x1380x400 mm',
            'hole_size' => '1380x1380',
            'fan_type' => 'Quạt thông gió vuông',
            'use_ventilation' => true,
            'use_cooling_pad' => true,
        ]);

        Product::where('sku', 'DETON-LYTAM-11KW')->update([
            'airflow' => 15000,
            'power' => '11 kW',
            'voltage' => '380V',
            'size_display' => 'Ø600 mm',
            'hole_size' => '600x600',
            'fan_type' => 'Quạt ly tâm',
            'use_ventilation' => true,
            'use_cooling_pad' => false,
        ]);

        Product::where('sku', 'DASIN-KVF-1845')->update([
            'airflow' => 3080,
            'power' => '135W',
            'voltage' => '220V',
            'size_display' => '450x450 mm',
            'hole_size' => '450x450',
            'fan_type' => 'Quạt thông gió vuông',
            'use_ventilation' => true,
            'use_cooling_pad' => false,
        ]);

        Product::where('sku', 'COOLING-PAD-7090')->update([
            'is_cooling_pad' => true,
            'use_cooling_pad' => true,
            'pad_area' => 1.08,
            'pad_thickness' => 150,
            'size_display' => '1800x600x150 mm',
        ]);

        Product::where('sku', 'NEDFON-DPT-200')->update([
            'airflow' => 900,
            'power' => '130W',
            'voltage' => '220V',
            'size_display' => 'Ø200 mm',
            'hole_size' => '250x250',
            'fan_type' => 'Quạt nối ống âm trần',
            'use_ventilation' => true,
            'use_cooling_pad' => false,
        ]);

        // Seed additional products for comprehensive calculation options
        $additional = [
            // Tab 1 & Tab 2 Benchmark Test Products
            [
                'name' => ['vi' => 'Quạt thông gió vuông công nghiệp LF1380', 'en' => 'LF1380 Industrial Exhaust Fan'],
                'sku' => 'LF1380',
                'brand_id' => $deton->id,
                'category_id' => $catSquare->id,
                'price' => 4350000,
                'airflow' => 48000, // Matches CP-01 benchmark in Excel v05
                'power' => '1.1 kW',
                'voltage' => '380V',
                'size_display' => '1380x1380x400 mm',
                'hole_size' => '1380x1380',
                'fan_type' => 'Quạt thông gió vuông',
                'use_ventilation' => true,
                'use_cooling_pad' => true,
                'image_url' => '/client-assets/images/km-vuong-1380.jpg',
                'short_description' => ['vi' => 'Lưu lượng 48.000 m³/h · 1.1kW 380V · Kích thước 1380x1380mm chuyên kết hợp Cooling Pad', 'en' => '48,000 m3/h, 1.1kW 380V for cooling pads'],
            ],
            [
                'name' => ['vi' => 'Quạt thông gió vuông Komasu KM-1380/380V', 'en' => 'Komasu Square Exhaust Fan KM-1380 46000'],
                'sku' => 'KM-1380-46K',
                'brand_id' => $komasu->id,
                'category_id' => $catSquare->id,
                'price' => 4250000,
                'airflow' => 46000, // Matches TG-01 benchmark in Excel v05
                'power' => '1.1 kW',
                'voltage' => '380V',
                'size_display' => '1380x1380x400 mm',
                'hole_size' => '1380x1380',
                'fan_type' => 'Quạt thông gió vuông',
                'use_ventilation' => true,
                'use_cooling_pad' => true,
                'image_url' => '/client-assets/images/km-vuong-1380.jpg',
                'short_description' => ['vi' => 'Lưu lượng 46.000 m³/h · Công suất 1.1kW 380V · Cánh Inox truyền động gián tiếp curoa', 'en' => '46,000 m3/h, 1.1kW 380V'],
            ],
            [
                'name' => ['vi' => 'Quạt thông gió vuông Komasu 1220x1220x400mm', 'en' => 'Komasu Square Fan 1220x1220mm'],
                'sku' => 'KM-VUONG-1220',
                'brand_id' => $komasu->id,
                'category_id' => $catSquare->id,
                'price' => 3850000,
                'airflow' => 38000,
                'power' => '0.75 kW',
                'voltage' => '380V',
                'size_display' => '1220x1220x400 mm',
                'hole_size' => '1220x1220',
                'fan_type' => 'Quạt thông gió vuông',
                'use_ventilation' => true,
                'use_cooling_pad' => true,
                'image_url' => '/client-assets/images/km-vuong-1380.jpg',
                'short_description' => ['vi' => 'Lưu lượng 38.000 m³/h · Công suất 0.75kW 380V · Kích thước 1220x1220mm', 'en' => '38,000 m3/h 0.75kW'],
            ],
            [
                'name' => ['vi' => 'Quạt thông gió vuông Komasu 1060x1060x400mm', 'en' => 'Komasu Square Fan 1060x1060mm'],
                'sku' => 'KM-VUONG-1060',
                'brand_id' => $komasu->id,
                'category_id' => $catSquare->id,
                'price' => 3450000,
                'airflow' => 28000,
                'power' => '0.55 kW',
                'voltage' => '380V',
                'size_display' => '1060x1060x400 mm',
                'hole_size' => '1060x1060',
                'fan_type' => 'Quạt thông gió vuông',
                'use_ventilation' => true,
                'use_cooling_pad' => true,
                'image_url' => '/client-assets/images/km-vuong-1380.jpg',
                'short_description' => ['vi' => 'Lưu lượng 28.000 m³/h · Công suất 0.55kW 380V · Kích thước 1060x1060mm', 'en' => '28,000 m3/h 0.55kW'],
            ],
            [
                'name' => ['vi' => 'Quạt thông gió vuông Deton FAG-900', 'en' => 'Deton FAG-900 Square Fan'],
                'sku' => 'DETON-FAG900',
                'brand_id' => $deton->id,
                'category_id' => $catSquare->id,
                'price' => 2950000,
                'airflow' => 22000,
                'power' => '0.37 kW',
                'voltage' => '380V',
                'size_display' => '900x900x400 mm',
                'hole_size' => '900x900',
                'fan_type' => 'Quạt thông gió vuông',
                'use_ventilation' => true,
                'use_cooling_pad' => true,
                'image_url' => '/client-assets/images/km-vuong-1380.jpg',
                'short_description' => ['vi' => 'Lưu lượng 22.000 m³/h · Công suất 0.37kW 380V · Kích thước 900x900mm', 'en' => '22,000 m3/h 0.37kW'],
            ],
            [
                'name' => ['vi' => 'Quạt thông gió vuông 1380 điện 220V 1 pha', 'en' => 'Square Fan 1380 220V Single Phase'],
                'sku' => 'KM-VUONG-1380-1P',
                'brand_id' => $komasu->id,
                'category_id' => $catSquare->id,
                'price' => 4350000,
                'airflow' => 44500,
                'power' => '1.1 kW',
                'voltage' => '220V',
                'size_display' => '1380x1380x400 mm',
                'hole_size' => '1380x1380',
                'fan_type' => 'Quạt thông gió vuông',
                'use_ventilation' => true,
                'use_cooling_pad' => true,
                'image_url' => '/client-assets/images/km-vuong-1380.jpg',
                'short_description' => ['vi' => 'Điện áp 220V (1 pha gia đình/xưởng nhỏ) · Lưu lượng 44.500 m³/h · 1.1kW', 'en' => '220V 44,500 m3/h'],
            ],

            // Tab 3 Office / Room / WC Ventilation Products
            [
                'name' => ['vi' => 'Quạt hút thông gió gắn tường Panasonic FV-20CUT1', 'en' => 'Panasonic FV-20CUT1 Wall Fan'],
                'sku' => 'PANASONIC-FV-20CUT1',
                'brand_id' => $panasonic->id,
                'category_id' => $catSquare->id,
                'price' => 890000,
                'airflow' => 540,
                'power' => '22W',
                'voltage' => '220V',
                'size_display' => '250x250 mm',
                'hole_size' => '250x250',
                'fan_type' => 'Quạt gắn tường',
                'use_ventilation' => true,
                'use_cooling_pad' => false,
                'image_url' => '/client-assets/images/km-treo-750.jpg',
                'short_description' => ['vi' => 'Lỗ chờ 250x250mm · Lưu lượng 540 m³/h · 22W 220V · Siêu êm cho phòng ngủ, văn phòng', 'en' => 'Hole 250x250mm, 540 m3/h'],
            ],
            [
                'name' => ['vi' => 'Quạt hút thông gió gắn tường Panasonic FV-25LUN', 'en' => 'Panasonic FV-25LUN Wall Fan'],
                'sku' => 'PANASONIC-FV-25LUN',
                'brand_id' => $panasonic->id,
                'category_id' => $catSquare->id,
                'price' => 990000,
                'airflow' => 830,
                'power' => '29W',
                'voltage' => '220V',
                'size_display' => '300x300 mm',
                'hole_size' => '300x300',
                'fan_type' => 'Quạt gắn tường',
                'use_ventilation' => true,
                'use_cooling_pad' => false,
                'image_url' => '/client-assets/images/km-treo-750.jpg',
                'short_description' => ['vi' => 'Lỗ chờ 300x300mm · Lưu lượng 830 m³/h · 29W 220V · Có màn che ngăn mùi côn trùng', 'en' => 'Hole 300x300mm, 830 m3/h'],
            ],
            [
                'name' => ['vi' => 'Quạt hút thông gió âm trần Panasonic FV-24CD8', 'en' => 'Panasonic Ceiling Fan FV-24CD8'],
                'sku' => 'PANASONIC-FV-24CD8',
                'brand_id' => $panasonic->id,
                'category_id' => $catDuct->id,
                'price' => 1250000,
                'airflow' => 170,
                'power' => '16W',
                'voltage' => '220V',
                'size_display' => '240x240 mm',
                'hole_size' => '240x240',
                'fan_type' => 'Quạt nối ống âm trần',
                'use_ventilation' => true,
                'use_cooling_pad' => false,
                'image_url' => '/client-assets/images/nedfon-dpt-200.jpg',
                'short_description' => ['vi' => 'Lỗ chờ 240x240mm · Lưu lượng 170 m³/h · Độ ồn cực thấp 28dB · Chuyên WC, phòng tắm', 'en' => 'Ceiling fan for bathroom/WC'],
            ],
            [
                'name' => ['vi' => 'Quạt hút âm trần nối ống Nedfon BPT10-13H25', 'en' => 'Nedfon BPT10 Ceiling Fan'],
                'sku' => 'NEDFON-BPT-10',
                'brand_id' => $nedfon->id,
                'category_id' => $catDuct->id,
                'price' => 720000,
                'airflow' => 150,
                'power' => '26W',
                'voltage' => '220V',
                'size_display' => '210x210 mm',
                'hole_size' => '210x210',
                'fan_type' => 'Quạt nối ống âm trần',
                'use_ventilation' => true,
                'use_cooling_pad' => false,
                'image_url' => '/client-assets/images/nedfon-dpt-200.jpg',
                'short_description' => ['vi' => 'Lỗ chờ 210x210mm · Lưu lượng 150 m³/h · 26W 220V · Động cơ bạc đạn kín', 'en' => 'Hole 210x210mm, 150 m3/h'],
            ],
            [
                'name' => ['vi' => 'Quạt hút âm trần nối ống Nedfon BPT15-33H35', 'en' => 'Nedfon BPT15 Ceiling Fan'],
                'sku' => 'NEDFON-BPT-15',
                'brand_id' => $nedfon->id,
                'category_id' => $catDuct->id,
                'price' => 1180000,
                'airflow' => 350,
                'power' => '38W',
                'voltage' => '220V',
                'size_display' => '290x290 mm',
                'hole_size' => '290x290',
                'fan_type' => 'Quạt nối ống âm trần',
                'use_ventilation' => true,
                'use_cooling_pad' => false,
                'image_url' => '/client-assets/images/nedfon-dpt-200.jpg',
                'short_description' => ['vi' => 'Lỗ chờ 290x290mm · Lưu lượng 350 m³/h · 38W 220V · Phù hợp văn phòng, phòng họp', 'en' => 'Hole 290x290mm, 350 m3/h'],
            ],
            [
                'name' => ['vi' => 'Quạt thông gió gắn tường Vinawind QTL-300', 'en' => 'Vinawind QTL-300 Wall Fan'],
                'sku' => 'VINAWIND-QTL-300',
                'brand_id' => $vinawind->id,
                'category_id' => $catSquare->id,
                'price' => 420000,
                'airflow' => 1080,
                'power' => '45W',
                'voltage' => '220V',
                'size_display' => '350x350 mm',
                'hole_size' => '350x350',
                'fan_type' => 'Quạt gắn tường',
                'use_ventilation' => true,
                'use_cooling_pad' => false,
                'image_url' => '/client-assets/images/km-treo-750.jpg',
                'short_description' => ['vi' => 'Lỗ chờ 350x350mm · Lưu lượng 1.080 m³/h · 45W 220V · Siêu bền Điện cơ Thống Nhất', 'en' => 'Hole 350x350mm, 1080 m3/h'],
            ],
            [
                'name' => ['vi' => 'Quạt thông gió gắn tường KDK 25AUH', 'en' => 'KDK 25AUH Wall Fan'],
                'sku' => 'KDK-25AUH',
                'brand_id' => $kdk->id,
                'category_id' => $catSquare->id,
                'price' => 1350000,
                'airflow' => 735,
                'power' => '29W',
                'voltage' => '220V',
                'size_display' => '300x300 mm',
                'hole_size' => '300x300',
                'fan_type' => 'Quạt gắn tường',
                'use_ventilation' => true,
                'use_cooling_pad' => false,
                'image_url' => '/client-assets/images/km-treo-750.jpg',
                'short_description' => ['vi' => 'Lỗ chờ 300x300mm · Lưu lượng 735 m³/h · 29W 220V · Thương hiệu Nhật Bản cao cấp', 'en' => 'Hole 300x300mm, 735 m3/h'],
            ],
        ];

        foreach ($additional as $data) {
            $sku = $data['sku'];
            $slug = Str::slug($data['name']['vi']);
            $product = Product::firstOrNew(['sku' => $sku]);
            $product->name = $data['name'];
            $product->slug = $slug;
            $product->sku = $sku;
            $product->brand_id = $data['brand_id'];
            $product->category_id = $data['category_id'];
            $product->price = $data['price'];
            $product->airflow = $data['airflow'];
            $product->power = $data['power'];
            $product->voltage = $data['voltage'];
            $product->size_display = $data['size_display'];
            $product->hole_size = $data['hole_size'];
            $product->fan_type = $data['fan_type'];
            $product->use_ventilation = $data['use_ventilation'];
            $product->use_cooling_pad = $data['use_cooling_pad'];
            $product->image_url = $data['image_url'];
            $product->short_description = $data['short_description'];
            $product->description = [
                'vi' => "Model {$sku} chính hãng Winline Việt Nam.\nLưu lượng: {$data['airflow']} m³/h\nCông suất: {$data['power']}\nĐiện áp: {$data['voltage']}",
                'en' => "Official model {$sku} distributed by Winline Vietnam.",
            ];
            $product->is_active = true;
            $product->is_featured = true;
            $product->stock_quantity = 100;
            $product->manage_stock = true;
            $product->published_at = now();
            $product->save();
        }
    }
}
