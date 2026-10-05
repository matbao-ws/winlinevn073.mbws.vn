<?php

use App\Models\Brand;
use App\Models\Category;
use App\Services\LocalizedSlugService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $slugService = app(LocalizedSlugService::class);

        // 1. Update/Add Brands with logos (Strategic order: Vinawind, Komasu, Chinghai, Nanyoo first)
        $brandsData = [
            ['slug' => 'vinawind', 'name' => ['vi' => 'Vinawind', 'en' => 'Vinawind'], 'image_url' => 'client-assets/images/brands/vinawind.svg', 'sort_order' => 1],
            ['slug' => 'komasu', 'name' => ['vi' => 'Komasu', 'en' => 'Komasu'], 'image_url' => 'client-assets/images/brands/komasu.svg', 'sort_order' => 2],
            ['slug' => 'chinghai', 'name' => ['vi' => 'Chinghai', 'en' => 'Chinghai'], 'image_url' => 'client-assets/images/brands/chinghai.svg', 'sort_order' => 3],
            ['slug' => 'nanyoo', 'name' => ['vi' => 'Nanyoo', 'en' => 'Nanyoo'], 'image_url' => 'client-assets/images/brands/nanyoo.svg', 'sort_order' => 4],
            ['slug' => 'panasonic', 'name' => ['vi' => 'Panasonic', 'en' => 'Panasonic'], 'image_url' => 'client-assets/images/brands/panasonic.svg', 'sort_order' => 5],
            ['slug' => 'nedfon', 'name' => ['vi' => 'Nedfon', 'en' => 'Nedfon'], 'image_url' => 'client-assets/images/brands/nedfon.svg', 'sort_order' => 6],
            ['slug' => 'deton', 'name' => ['vi' => 'Deton', 'en' => 'Deton'], 'image_url' => 'client-assets/images/brands/deton.svg', 'sort_order' => 7],
            ['slug' => 'dasin', 'name' => ['vi' => 'Dasin', 'en' => 'Dasin'], 'image_url' => 'client-assets/images/brands/dasin.svg', 'sort_order' => 8],
            ['slug' => 'kdk', 'name' => ['vi' => 'KDK', 'en' => 'KDK'], 'image_url' => 'client-assets/images/brands/kdk.svg', 'sort_order' => 9],
            ['slug' => 'mitsubishi', 'name' => ['vi' => 'Mitsubishi', 'en' => 'Mitsubishi'], 'image_url' => 'client-assets/images/brands/mitsubishi.svg', 'sort_order' => 10],
            ['slug' => 'tico', 'name' => ['vi' => 'Tico', 'en' => 'Tico'], 'image_url' => 'client-assets/images/brands/tico.svg', 'sort_order' => 11],
            ['slug' => 'hatari', 'name' => ['vi' => 'Hatari', 'en' => 'Hatari'], 'image_url' => 'client-assets/images/brands/hatari.svg', 'sort_order' => 12],
        ];

        foreach ($brandsData as $bData) {
            $brand = Brand::query()->updateOrCreate(
                ['slug' => $bData['slug']],
                [
                    'name' => $bData['name'],
                    'image_url' => $bData['image_url'],
                    'sort_order' => $bData['sort_order'],
                    'is_active' => true,
                ]
            );
            try {
                $slugService->sync($brand, ['vi' => $bData['slug'], 'en' => $bData['slug']]);
            } catch (\Throwable $e) {}
        }

        // 2. Hierarchy of Categories (Level 1 & Level 2 with images)
        $hierarchy = [
            [
                'slug' => 'quat-dan-dung',
                'name' => ['vi' => 'Quạt dân dụng', 'en' => 'Residential Fans'],
                'image_url' => 'client-assets/images/panasonic-tran.jpg',
                'sort_order' => 1,
                'children' => [
                    ['slug' => 'quat-tran', 'name' => ['vi' => 'Quạt trần', 'en' => 'Ceiling Fans'], 'image_url' => 'client-assets/images/panasonic-tran.jpg', 'sort_order' => 1],
                    ['slug' => 'quat-cay', 'name' => ['vi' => 'Quạt cây đứng', 'en' => 'Stand Fans'], 'image_url' => 'client-assets/images/km750s.jpg', 'sort_order' => 2],
                    ['slug' => 'quat-treo-tuong', 'name' => ['vi' => 'Quạt treo tường', 'en' => 'Wall Fans'], 'image_url' => 'client-assets/images/km-treo-750.jpg', 'sort_order' => 3],
                    ['slug' => 'quat-dao-tran', 'name' => ['vi' => 'Quạt đảo trần', 'en' => 'Orbit Fans'], 'image_url' => 'client-assets/images/panasonic-tran.jpg', 'sort_order' => 4],
                    ['slug' => 'quat-hop', 'name' => ['vi' => 'Quạt hộp & Quạt bàn', 'en' => 'Box & Desk Fans'], 'image_url' => 'client-assets/images/hatari-ip22m1.jpg', 'sort_order' => 5],
                    ['slug' => 'quat-san', 'name' => ['vi' => 'Quạt sàn chân quỳ', 'en' => 'Floor Fans'], 'image_url' => 'client-assets/images/dasin-san.jpg', 'sort_order' => 6],
                    ['slug' => 'quat-thong-gio', 'name' => ['vi' => 'Quạt thông gió dân dụng', 'en' => 'Home Exhaust Fans'], 'image_url' => 'client-assets/images/nedfon-noi-ong.jpg', 'sort_order' => 7],
                ]
            ],
            [
                'slug' => 'quat-cong-nghiep',
                'name' => ['vi' => 'Quạt công nghiệp', 'en' => 'Industrial Fans'],
                'image_url' => 'client-assets/images/km650s.jpg',
                'sort_order' => 2,
                'children' => [
                    ['slug' => 'quat-cay-cong-nghiep', 'name' => ['vi' => 'Quạt cây công nghiệp', 'en' => 'Industrial Stand Fans'], 'image_url' => 'client-assets/images/km750s.jpg', 'sort_order' => 1],
                    ['slug' => 'quat-treo-cong-nghiep', 'name' => ['vi' => 'Quạt treo công nghiệp', 'en' => 'Industrial Wall Fans'], 'image_url' => 'client-assets/images/km-treo-750.jpg', 'sort_order' => 2],
                    ['slug' => 'quat-san-cong-nghiep', 'name' => ['vi' => 'Quạt sàn công nghiệp', 'en' => 'Industrial Floor Fans'], 'image_url' => 'client-assets/images/dasin-san.jpg', 'sort_order' => 3],
                    ['slug' => 'quat-thong-gio-vuong', 'name' => ['vi' => 'Quạt thông gió vuông', 'en' => 'Square Exhaust Fans'], 'image_url' => 'client-assets/images/km-vuong-1380.jpg', 'sort_order' => 4],
                    ['slug' => 'quat-hut-xach-tay', 'name' => ['vi' => 'Quạt hút xách tay', 'en' => 'Portable Ventilators'], 'image_url' => 'client-assets/images/deton-fag1380.jpg', 'sort_order' => 5],
                    ['slug' => 'quat-ly-tam', 'name' => ['vi' => 'Quạt ly tâm công nghiệp', 'en' => 'Centrifugal Blowers'], 'image_url' => 'client-assets/images/deton-lytam.jpg', 'sort_order' => 6],
                    ['slug' => 'quat-huong-truc', 'name' => ['vi' => 'Quạt hướng trục', 'en' => 'Axial Flow Fans'], 'image_url' => 'client-assets/images/deton-fag1380.jpg', 'sort_order' => 7],
                ]
            ],
            [
                'slug' => 'he-thong-thong-gio-lam-mat',
                'name' => ['vi' => 'Thông gió & Làm mát', 'en' => 'Ventilation & Cooling'],
                'image_url' => 'client-assets/images/air-cooler-18000.jpg',
                'sort_order' => 3,
                'children' => [
                    ['slug' => 'tam-lam-mat-cooling-pad', 'name' => ['vi' => 'Tấm làm mát Cooling Pad', 'en' => 'Cooling Pads'], 'image_url' => 'client-assets/images/cooling-pad.jpg', 'sort_order' => 1],
                    ['slug' => 'may-lam-mat-cong-nghiep', 'name' => ['vi' => 'Máy làm mát công nghiệp', 'en' => 'Industrial Air Coolers'], 'image_url' => 'client-assets/images/air-cooler-18000.jpg', 'sort_order' => 2],
                    ['slug' => 'quat-cat-gio', 'name' => ['vi' => 'Quạt cắt gió Air Curtain', 'en' => 'Air Curtains'], 'image_url' => 'client-assets/images/nedfon-noi-ong.jpg', 'sort_order' => 3],
                    ['slug' => 'quat-cap-khi-tuoi-erv', 'name' => ['vi' => 'Quạt cấp khí tươi ERV', 'en' => 'ERV Ventilators'], 'image_url' => 'client-assets/images/nedfon-noi-ong.jpg', 'sort_order' => 4],
                    ['slug' => 'ong-gio-phu-kien', 'name' => ['vi' => 'Ống gió & Phụ kiện', 'en' => 'Ducts & Accessories'], 'image_url' => 'client-assets/images/cooling-pad.jpg', 'sort_order' => 5],
                ]
            ],
        ];

        foreach ($hierarchy as $pData) {
            $parent = Category::query()->updateOrCreate(
                ['slug' => $pData['slug']],
                [
                    'parent_id' => null,
                    'name' => $pData['name'],
                    'image_url' => $pData['image_url'],
                    'sort_order' => $pData['sort_order'],
                    'is_active' => true,
                ]
            );
            try {
                $slugService->sync($parent, ['vi' => $pData['slug'], 'en' => $pData['slug']]);
            } catch (\Throwable $e) {}

            foreach ($pData['children'] as $cData) {
                $child = Category::query()->updateOrCreate(
                    ['slug' => $cData['slug']],
                    [
                        'parent_id' => $parent->id,
                        'name' => $cData['name'],
                        'image_url' => $cData['image_url'],
                        'sort_order' => $cData['sort_order'],
                        'is_active' => true,
                    ]
                );
                try {
                    $slugService->sync($child, ['vi' => $cData['slug'], 'en' => $cData['slug']]);
                } catch (\Throwable $e) {}
            }
        }
    }

    public function down(): void
    {
    }
};
