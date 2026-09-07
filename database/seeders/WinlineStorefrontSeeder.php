<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProjectSetting;
use App\Services\LocalizedSlugService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WinlineStorefrontSeeder extends Seeder
{
    public function run(): void
    {
        $slugService = app(LocalizedSlugService::class);

        // 1. Brands
        $brandsData = [
            ['slug' => 'komasu', 'name' => ['vi' => 'Komasu', 'en' => 'Komasu'], 'description' => ['vi' => 'Thương hiệu quạt công nghiệp Nhật Bản uy tín hàng đầu, 100% dây đồng.', 'en' => 'Leading Japanese industrial fan brand with 100% copper motor.'], 'sort_order' => 1],
            ['slug' => 'vinawind', 'name' => ['vi' => 'Vinawind', 'en' => 'Vinawind'], 'description' => ['vi' => 'Điện cơ Thống Nhất - Thương hiệu quốc gia Việt Nam bền bỉ và tiết kiệm điện.', 'en' => 'National Vietnamese fan manufacturer, durable and energy efficient.'], 'sort_order' => 2],
            ['slug' => 'deton', 'name' => ['vi' => 'Deton', 'en' => 'Deton'], 'description' => ['vi' => 'Tập đoàn quạt công nghiệp và quạt ly tâm công suất lớn hàng đầu châu Á.', 'en' => 'Top Asian industrial fan and centrifugal blower manufacturer.'], 'sort_order' => 3],
            ['slug' => 'dasin', 'name' => ['vi' => 'Dasin', 'en' => 'Dasin'], 'description' => ['vi' => 'Quạt công nghiệp cao cấp Đài Loan, motor bạc đạn bôi trơn vĩnh cửu chống bụi.', 'en' => 'Premium Taiwanese industrial fan with sealed ball bearings.'], 'sort_order' => 4],
            ['slug' => 'chinghai', 'name' => ['vi' => 'Chinghai', 'en' => 'Chinghai'], 'description' => ['vi' => 'Quạt công nghiệp xuất khẩu Đài Loan động cơ dây đồng siêu bền bỉ.', 'en' => 'Taiwanese industrial fan export grade, robust copper motor.'], 'sort_order' => 5],
            ['slug' => 'hatari', 'name' => ['vi' => 'Hatari', 'en' => 'Hatari'], 'description' => ['vi' => 'Quạt điện và quạt công nghiệp số 1 Thái Lan đạt chuẩn an toàn TIS.', 'en' => 'Thailand number 1 electric and industrial fan brand.'], 'sort_order' => 6],
            ['slug' => 'panasonic', 'name' => ['vi' => 'Panasonic', 'en' => 'Panasonic'], 'description' => ['vi' => 'Tập đoàn thiết bị điện và quạt thông gió hàng đầu Nhật Bản.', 'en' => 'World leading Japanese electrical and ventilation systems.'], 'sort_order' => 7],
            ['slug' => 'nedfon', 'name' => ['vi' => 'Nedfon', 'en' => 'Nedfon'], 'description' => ['vi' => 'Chuyên gia quạt thông gió âm trần, nối ống và thu hồi nhiệt ERV.', 'en' => 'Expert in inline duct fans and energy recovery ventilators.'], 'sort_order' => 8],
            ['slug' => 'nanyoo', 'name' => ['vi' => 'Nanyoo', 'en' => 'Nanyoo'], 'description' => ['vi' => 'Thiết bị thông gió thu hồi nhiệt và quạt cắt gió công nghiệp.', 'en' => 'Ventilation, ERV and air curtain systems.'], 'sort_order' => 9],
        ];

        $brands = [];
        foreach ($brandsData as $bData) {
            $brand = Brand::query()->updateOrCreate(
                ['slug' => $bData['slug']],
                [
                    'name' => $bData['name'],
                    'description' => $bData['description'],
                    'sort_order' => $bData['sort_order'],
                    'is_active' => true,
                ]
            );
            $slugService->sync($brand, ['vi' => $bData['slug'], 'en' => $bData['slug']]);
            $brands[$bData['slug']] = $brand;
        }

        // 2. Categories
        $categoriesData = [
            [
                'slug' => 'quat-cong-nghiep',
                'name' => ['vi' => 'Quạt công nghiệp', 'en' => 'Industrial Fans'],
                'description' => ['vi' => 'Quạt đứng, quạt treo tường, quạt sàn chân quỳ công suất lớn 150W - 250W.', 'en' => 'Heavy duty pedestal, wall mounted, and floor fans 150W - 250W.'],
                'sort_order' => 1,
            ],
            [
                'slug' => 'quat-thong-gio-cong-nghiep',
                'name' => ['vi' => 'Quạt thông gió công nghiệp', 'en' => 'Industrial Exhaust Fans'],
                'description' => ['vi' => 'Quạt vuông thông gió trang trại, quạt hút gắn tường nhà xưởng 1380x1380, 1060, 900.', 'en' => 'Square industrial exhaust fans 1380x1380, 1060, 900.'],
                'sort_order' => 2,
            ],
            [
                'slug' => 'quat-ly-tam',
                'name' => ['vi' => 'Quạt ly tâm', 'en' => 'Centrifugal Blowers'],
                'description' => ['vi' => 'Quạt ly tâm hút bụi gỗ, hút khói bếp ăn, quạt PCCC áp suất cao.', 'en' => 'Centrifugal fans for dust collection, kitchen exhaust and fire safety.'],
                'sort_order' => 3,
            ],
            [
                'slug' => 'quat-huong-truc',
                'name' => ['vi' => 'Quạt hướng trục', 'en' => 'Axial Fans'],
                'description' => ['vi' => 'Quạt hướng trục tăng áp buồng thang, hút gió tầng hầm và thông gió đường ống.', 'en' => 'Axial flow fans for stairwell pressurization and basement ventilation.'],
                'sort_order' => 4,
            ],
            [
                'slug' => 'may-lam-mat-cong-nghiep',
                'name' => ['vi' => 'Máy làm mát công nghiệp', 'en' => 'Industrial Air Coolers'],
                'description' => ['vi' => 'Máy làm mát hơi nước Air Cooler 18.000 - 30.000 m³/h làm mát diện rộng.', 'en' => 'Evaporative air coolers 18,000 - 30,000 m3/h for workshops.'],
                'sort_order' => 5,
            ],
            [
                'slug' => 'tam-lam-mat-cooling-pad',
                'name' => ['vi' => 'Tấm làm mát Cooling Pad', 'en' => 'Cooling Pads'],
                'description' => ['vi' => 'Tấm làm mát cooling pad chống rêu 7090, 5090 cho hệ thống áp suất âm nhà xưởng.', 'en' => 'Anti-algae cooling pads 7090 and 5090 for negative pressure cooling.'],
                'sort_order' => 6,
            ],
            [
                'slug' => 'quat-dan-dung',
                'name' => ['vi' => 'Quạt dân dụng', 'en' => 'Commercial & Residential Fans'],
                'description' => ['vi' => 'Quạt trần, quạt đảo trần, quạt hộp, quạt đứng gia đình Vinawind, Panasonic.', 'en' => 'Ceiling fans, orbit fans, box fans for homes and offices.'],
                'sort_order' => 7,
            ],
            [
                'slug' => 'he-thong-thong-gio-lam-mat',
                'name' => ['vi' => 'Hệ thống thông gió & làm mát', 'en' => 'Ventilation & Cooling Systems'],
                'description' => ['vi' => 'Hệ thống quạt thu hồi nhiệt ERV, quạt cắt gió, ống gió mềm và phụ kiện HVAC.', 'en' => 'ERV heat recovery, air curtains, flexible ducts and HVAC accessories.'],
                'sort_order' => 8,
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cData) {
            $cat = Category::query()->updateOrCreate(
                ['slug' => $cData['slug']],
                [
                    'name' => $cData['name'],
                    'description' => $cData['description'],
                    'sort_order' => $cData['sort_order'],
                    'is_active' => true,
                ]
            );
            $slugService->sync($cat, ['vi' => $cData['slug'], 'en' => $cData['slug']]);
            $categories[$cData['slug']] = $cat;
        }

        // 3. Products
        $productsData = [
            [
                'sku' => 'KM-750S',
                'category' => 'quat-cong-nghiep',
                'brand' => 'komasu',
                'name' => ['vi' => 'Quạt cây công nghiệp Komasu KM-750S', 'en' => 'Komasu Industrial Stand Fan KM-750S'],
                'price' => 2630000,
                'compare_at_price' => 2950000,
                'short_description' => ['vi' => 'Công suất 250W · Sải cánh 750mm · Lưu lượng 15.200 m³/h · 100% dây đồng', 'en' => '250W Power, 750mm blade, 15,200 m3/h airflow, 100% copper motor'],
                'description' => ['vi' => "Model: KM-750S\nCông suất: 250W\nĐiện áp: 220V/50Hz\nSải cánh: 750mm\nLưu lượng gió: 15.200 m³/h\nTốc độ quay: 1400 vòng/phút\nXuất xứ: Việt Nam (Linh kiện nhập khẩu Nhật Bản)\nBảo hành chính hãng: 12 tháng tận nơi", 'en' => 'Komasu KM-750S 250W pedestal fan.'],
                'image_url' => 'client-assets/images/km750s.jpg',
                'is_featured' => true,
                'stock_quantity' => 150,
            ],
            [
                'sku' => 'KM-650S',
                'category' => 'quat-cong-nghiep',
                'brand' => 'komasu',
                'name' => ['vi' => 'Quạt cây công nghiệp Komasu KM-650S', 'en' => 'Komasu Industrial Stand Fan KM-650S'],
                'price' => 2180000,
                'compare_at_price' => 2450000,
                'short_description' => ['vi' => 'Công suất 200W · Sải cánh 650mm · Lưu lượng 12.000 m³/h · 3 tốc độ gió', 'en' => '200W Power, 650mm blade, 12,000 m3/h airflow, 3 speeds'],
                'description' => ['vi' => "Model: KM-650S\nCông suất: 200W\nSải cánh: 650mm\nĐiện áp: 220V\nBảo hành: 12 tháng chính hãng", 'en' => 'Komasu KM-650S industrial stand fan.'],
                'image_url' => 'client-assets/images/km650s.jpg',
                'is_featured' => true,
                'stock_quantity' => 80,
            ],
            [
                'sku' => 'KM-VUONG-1380',
                'category' => 'quat-thong-gio-cong-nghiep',
                'brand' => 'komasu',
                'name' => ['vi' => 'Quạt thông gió vuông Komasu 1380x1380x400mm', 'en' => 'Komasu Square Exhaust Fan 1380x1380mm'],
                'price' => 4150000,
                'compare_at_price' => 4600000,
                'short_description' => ['vi' => 'Kích thước 1380x1380 · Công suất 1.1kW · Lưu lượng gió 44.500 m³/h · Cánh Inox 430', 'en' => 'Size 1380x1380mm, 1.1kW, 44,500 m3/h airflow, stainless steel blades'],
                'description' => ['vi' => "Kích thước khung: 1380 x 1380 x 400 mm\nĐường kính cánh: 1250 mm\nLưu lượng gió: 44.500 m³/h\nCông suất: 1.1 kW\nĐiện áp: 380V (3 pha) hoặc 220V (1 pha)\nKhung vỏ: Tôn mạ kẽm độ mạ 180g/m2, chớp che mưa tự động", 'en' => 'Square exhaust fan 1380x1380mm for warehouses and farms.'],
                'image_url' => 'client-assets/images/km-vuong-1380.jpg',
                'is_featured' => true,
                'stock_quantity' => 200,
            ],
            [
                'sku' => 'KM-TREO-750',
                'category' => 'quat-cong-nghiep',
                'brand' => 'komasu',
                'name' => ['vi' => 'Quạt treo tường công nghiệp Komasu KM-750', 'en' => 'Komasu Industrial Wall Fan KM-750'],
                'price' => 2450000,
                'compare_at_price' => 2700000,
                'short_description' => ['vi' => 'Công suất 250W · Sải cánh 750mm · Gắn tường tiết kiệm diện tích · Chân đế sắt vững chắc', 'en' => '250W Power, 750mm blade, heavy duty wall mounting bracket'],
                'description' => ['vi' => "Model: KM-750 Treo tường\nCông suất: 250W\nĐiện áp: 220V\nSải cánh: 750mm\nLưu lượng gió: 15.200 m³/h\nBảo hành: 12 tháng", 'en' => 'Komasu KM-750 industrial wall fan.'],
                'image_url' => 'client-assets/images/km-treo-750.jpg',
                'is_featured' => false,
                'stock_quantity' => 120,
            ],
            [
                'sku' => 'DETON-FAG1380',
                'category' => 'quat-thong-gio-cong-nghiep',
                'brand' => 'deton',
                'name' => ['vi' => 'Quạt thông gió vuông Deton FAG-1380', 'en' => 'Deton Square Exhaust Fan FAG-1380'],
                'price' => 4250000,
                'compare_at_price' => 4800000,
                'short_description' => ['vi' => 'Kích thước 1380x1380mm · Công suất 1.1kW · Lưu lượng 44.000 m³/h · Động cơ Furlong', 'en' => '1380x1380mm, 1.1kW, 44,000 m3/h airflow, Furlong motor'],
                'description' => ['vi' => "Model: FAG-1380\nKích thước: 1380 x 1380 x 400mm\nLưu lượng: 44.000 m³/h\nCông suất: 1.1kW\nĐộng cơ dây đồng chuẩn IP55 cách điện cấp F", 'en' => 'Deton FAG-1380 industrial square exhaust fan.'],
                'image_url' => 'client-assets/images/deton-fag1380.jpg',
                'is_featured' => true,
                'stock_quantity' => 180,
            ],
            [
                'sku' => 'DETON-DHF-750',
                'category' => 'quat-cong-nghiep',
                'brand' => 'deton',
                'name' => ['vi' => 'Quạt đứng công nghiệp Deton DHF-750', 'en' => 'Deton Industrial Stand Fan DHF-750'],
                'price' => 2550000,
                'compare_at_price' => 2850000,
                'short_description' => ['vi' => 'Công suất 220W · Sải cánh 750mm · Lưu lượng 18.120 m³/h · Chân đế gang đúc chống rung', 'en' => '220W Power, 750mm blade, 18,120 m3/h airflow, cast iron base'],
                'description' => ['vi' => "Model: DHF-750\nCông suất: 220W\nSải cánh: 750mm\nLưu lượng: 18.120 m³/h\nĐộ ồn thấp, chân đế gang đúc vững chắc", 'en' => 'Deton DHF-750 industrial stand fan.'],
                'image_url' => 'client-assets/images/dhf750.jpg',
                'is_featured' => false,
                'stock_quantity' => 95,
            ],
            [
                'sku' => 'DETON-LYTAM-11KW',
                'category' => 'quat-ly-tam',
                'brand' => 'deton',
                'name' => ['vi' => 'Quạt ly tâm hút bụi & PCCC Deton 11kW', 'en' => 'Deton High Pressure Centrifugal Fan 11kW'],
                'price' => 18500000,
                'compare_at_price' => 21000000,
                'short_description' => ['vi' => 'Công suất 11kW · Cột áp cao 2200 Pa · Lưu lượng 15.000 m³/h · Chuyên hút bụi nhà xưởng & PCCC', 'en' => '11kW Power, 2200 Pa pressure, 15,000 m3/h airflow for dust & smoke extraction'],
                'description' => ['vi' => "Dòng quạt ly tâm trung áp / cao áp công suất lớn 11kW chuyên dụng cho hệ thống hút bụi xưởng gỗ, xưởng cơ khí, hút khói bếp ăn công nghiệp và hệ thống PCCC tòa nhà.", 'en' => 'Deton 11kW centrifugal fan for industrial extraction.'],
                'image_url' => 'client-assets/images/deton-lytam.jpg',
                'is_featured' => true,
                'stock_quantity' => 25,
            ],
            [
                'sku' => 'DASIN-KVF-1845',
                'category' => 'quat-thong-gio-cong-nghiep',
                'brand' => 'dasin',
                'name' => ['vi' => 'Quạt thông gió đảo chiều Dasin KVF-1845', 'en' => 'Dasin Reversible Exhaust Fan KVF-1845'],
                'price' => 1850000,
                'compare_at_price' => 2050000,
                'short_description' => ['vi' => 'Công suất 135W · Sải cánh 450mm · Đảo chiều hút và thổi gió 2 chiều · Motor kín chống bụi nước', 'en' => '135W, 450mm blade, 2-way reversible exhaust fan, sealed motor'],
                'description' => ['vi' => "Model: KVF-1845\nSải cánh: 450mm\nCông suất: 135W\nTính năng: Đổi chiều quay hút/thổi gió chỉ với công tắc đảo chiều\nVòng bi Nhật Bản vận hành êm ái 24/7", 'en' => 'Dasin KVF-1845 2-way reversible industrial fan.'],
                'image_url' => 'client-assets/images/dasin-kvf1845.jpg',
                'is_featured' => false,
                'stock_quantity' => 60,
            ],
            [
                'sku' => 'DASIN-SAN-KSF',
                'category' => 'quat-cong-nghiep',
                'brand' => 'dasin',
                'name' => ['vi' => 'Quạt sàn di động Dasin KSF-2460', 'en' => 'Dasin Floor Fan KSF-2460'],
                'price' => 2290000,
                'compare_at_price' => 2550000,
                'short_description' => ['vi' => 'Công suất 150W · Sải cánh 600mm · Quạt sàn bánh xe di chuyển tiện lợi · Motor bạc đạn bôi trơn vĩnh cửu', 'en' => '150W Power, 600mm blade, portable floor fan with wheels'],
                'description' => ['vi' => "Model: KSF-2460\nSải cánh: 600mm\nCông suất: 150W\nCó bánh xe di chuyển tiện lợi, phù hợp làm mát cục bộ công nhân đứng máy xưởng cơ khí, may mặc.", 'en' => 'Dasin KSF-2460 floor fan with wheels.'],
                'image_url' => 'client-assets/images/dasin-san.jpg',
                'is_featured' => false,
                'stock_quantity' => 45,
            ],
            [
                'sku' => 'CHINGHAI-W9199',
                'category' => 'quat-cong-nghiep',
                'brand' => 'chinghai',
                'name' => ['vi' => 'Quạt đứng công nghiệp Chinghai W9199', 'en' => 'Chinghai Industrial Stand Fan W9199'],
                'price' => 1950000,
                'compare_at_price' => 2200000,
                'short_description' => ['vi' => 'Công suất 160W · Sải cánh 700mm · Động cơ Đài Loan 100% dây đồng · Chạy cực êm và mát', 'en' => '160W Power, 700mm blade, 100% copper Taiwanese motor'],
                'description' => ['vi' => "Model: W9199\nSải cánh: 700mm\nCông suất: 160W\nĐiện áp: 220V\nBảo hành chính hãng: 12 tháng", 'en' => 'Chinghai W9199 stand fan.'],
                'image_url' => 'client-assets/images/chinghai-w9199.jpg',
                'is_featured' => false,
                'stock_quantity' => 70,
            ],
            [
                'sku' => 'HATARI-IP22M1',
                'category' => 'quat-cong-nghiep',
                'brand' => 'hatari',
                'name' => ['vi' => 'Quạt cây công nghiệp cao cấp Hatari IP22M1', 'en' => 'Hatari Premium Industrial Fan IP22M1'],
                'price' => 2190000,
                'compare_at_price' => 2450000,
                'short_description' => ['vi' => 'Công suất 197W · Sải cánh 22 inch (56cm) · Nhập khẩu nguyên chiếc Thái Lan · Đạt chuẩn an toàn TIS', 'en' => '197W Power, 22-inch blade, imported from Thailand with TIS safety mark'],
                'description' => ['vi' => "Model: IP22M1\nXuất xứ: Thái Lan\nCông suất: 197W\nSải cánh: 22 inch (560mm)\nThiết kế sang trọng, độ bền cao, phù hợp nhà hàng, quán cafe, showroom.", 'en' => 'Hatari IP22M1 stand fan from Thailand.'],
                'image_url' => 'client-assets/images/hatari-ip22m1.jpg',
                'is_featured' => true,
                'stock_quantity' => 50,
            ],
            [
                'sku' => 'AIR-COOLER-18000',
                'category' => 'may-lam-mat-cong-nghiep',
                'brand' => 'komasu',
                'name' => ['vi' => 'Máy làm mát nhà xưởng công nghiệp Air Cooler 18000', 'en' => 'Industrial Evaporative Air Cooler 18000'],
                'price' => 7500000,
                'compare_at_price' => 8500000,
                'short_description' => ['vi' => 'Công suất 1.1kW · Lưu lượng gió 18.000 m³/h · Diện tích làm mát 100 - 150m² · Tiết kiệm 80% điện', 'en' => '1.1kW Power, 18,000 m3/h airflow, cooling area 100-150m2, saves 80% power'],
                'description' => ['vi' => "Lưu lượng khí: 18.000 m³/h\nCông suất điện: 1.1 kW\nĐiện áp: 380V hoặc 220V\nDiện tích làm mát: 100 - 150 m²\nBình chứa nước: Cấp nước tự động\nHiệu quả giảm nhiệt độ từ 5°C đến 10°C so với môi trường ngoài trời.", 'en' => 'Industrial Air Cooler 18000 for workshops.'],
                'image_url' => 'client-assets/images/air-cooler-18000.jpg',
                'is_featured' => true,
                'stock_quantity' => 40,
            ],
            [
                'sku' => 'COOLING-PAD-7090',
                'category' => 'tam-lam-mat-cooling-pad',
                'brand' => 'komasu',
                'name' => ['vi' => 'Tấm làm mát chống rêu Cooling Pad 7090 (1800x600x150mm)', 'en' => 'Anti-algae Cooling Pad 7090 (1800x600x150mm)'],
                'price' => 480000,
                'compare_at_price' => 550000,
                'short_description' => ['vi' => 'Kích thước 1800 x 600 x 150mm · Sợi cellulose phủ màng chống rêu mốc màu đen · Độ thẩm thấu nước cao', 'en' => '1800x600x150mm anti-algae cooling pad for negative pressure systems'],
                'description' => ['vi' => "Kích thước: Cao 1800mm x Rộng 600mm x Dày 150mm\nChất liệu: Giấy kraft nguyên sinh phủ keo kháng nước và màng chống rêu bề mặt màu đen/xanh.\nỨng dụng kết hợp quạt vuông 1380 trong hệ thống làm mát áp suất âm nhà xưởng may, trang trại.", 'en' => 'Cooling pad 7090 1800x600x150mm.'],
                'image_url' => 'client-assets/images/cooling-pad.jpg',
                'is_featured' => false,
                'stock_quantity' => 500,
            ],
            [
                'sku' => 'NEDFON-DPT-200',
                'category' => 'he-thong-thong-gio-lam-mat',
                'brand' => 'nedfon',
                'name' => ['vi' => 'Quạt hút thông gió nối ống âm trần Nedfon DPT-200', 'en' => 'Nedfon Inline Duct Fan DPT-200'],
                'price' => 2850000,
                'compare_at_price' => 3200000,
                'short_description' => ['vi' => 'Công suất 130W · Lưu lượng 900 m³/h · Độ ồn cực thấp ≤ 45dB · Chuyên dụng cho biệt thự, văn phòng, căn hộ', 'en' => '130W, 900 m3/h airflow, ultra quiet <= 45dB for villas and offices'],
                'description' => ['vi' => "Model: DPT20-55B (DPT-200)\nĐường kính ống: Ø200mm\nLưu lượng gió: 900 m³/h\nCông suất: 130W\nĐộ ồn: 45 dB\nBảo hành chính hãng: 24 tháng", 'en' => 'Nedfon DPT-200 inline duct fan.'],
                'image_url' => 'client-assets/images/nedfon-noi-ong.jpg',
                'is_featured' => false,
                'stock_quantity' => 60,
            ],
            [
                'sku' => 'PANASONIC-F-60TAN',
                'category' => 'quat-dan-dung',
                'brand' => 'panasonic',
                'name' => ['vi' => 'Quạt trần 5 cánh Panasonic F-60TAN có điều khiển', 'en' => 'Panasonic 5-Blade Ceiling Fan F-60TAN'],
                'price' => 6890000,
                'compare_at_price' => 7500000,
                'short_description' => ['vi' => 'Động cơ DC 37W siêu tiết kiệm điện · Sải cánh 150cm · 9 cấp độ gió · Cảm biến nhiệt độ Econavi', 'en' => '37W DC motor, 150cm blade, 9 speeds, Econavi sensor with remote'],
                'description' => ['vi' => "Model: F-60TAN\nĐộng cơ: DC siêu êm và tiết kiệm điện\nSải cánh: 1500mm\nTính năng: Chức năng tạo gió tự nhiên 1/f Yuragi, cảm biến Econavi tự điều chỉnh lưu lượng theo nhiệt độ phòng.\nBảo hành chính hãng: 12 tháng tận nơi", 'en' => 'Panasonic F-60TAN ceiling fan.'],
                'image_url' => 'client-assets/images/panasonic-tran.jpg',
                'is_featured' => true,
                'stock_quantity' => 35,
            ],
            [
                'sku' => 'VINAWIND-QD-750',
                'category' => 'quat-cong-nghiep',
                'brand' => 'vinawind',
                'name' => ['vi' => 'Quạt đứng công nghiệp Vinawind QĐ-750', 'en' => 'Vinawind Industrial Stand Fan QD-750'],
                'price' => 2050000,
                'compare_at_price' => 2300000,
                'short_description' => ['vi' => 'Công suất 180W · Sải cánh 750mm · Điện cơ Thống Nhất chính hãng · Bền bỉ theo năm tháng', 'en' => '180W Power, 750mm blade, genuine Vinawind classic industrial fan'],
                'description' => ['vi' => "Model: QĐ-750\nThương hiệu: Vinawind (Điện cơ Thống Nhất)\nSải cánh: 750mm\nCông suất: 180W\nĐiện áp: 220V\nBảo hành: 12 tháng", 'en' => 'Vinawind QD-750 stand fan.'],
                'image_url' => 'client-assets/images/qd750.jpg',
                'is_featured' => false,
                'stock_quantity' => 110,
            ],
        ];

        foreach ($productsData as $i => $p) {
            $cat = $categories[$p['category']] ?? null;
            $brand = $brands[$p['brand']] ?? null;

            $slug = Str::slug($p['name']['vi']);
            $product = Product::query()->updateOrCreate(
                ['sku' => $p['sku']],
                [
                    'category_id' => $cat?->id,
                    'brand_id' => $brand?->id,
                    'name' => $p['name'],
                    'slug' => $slug,
                    'short_description' => $p['short_description'],
                    'description' => $p['description'],
                    'image_url' => $p['image_url'],
                    'price' => $p['price'],
                    'compare_at_price' => $p['compare_at_price'] ?? null,
                    'stock_quantity' => $p['stock_quantity'] ?? 100,
                    'manage_stock' => true,
                    'is_active' => true,
                    'is_featured' => $p['is_featured'] ?? false,
                    'sort_order' => $i + 1,
                    'published_at' => now(),
                ]
            );
            $slugService->sync($product, ['vi' => $slug, 'en' => $slug]);
        }

        // 4. Post Categories & Posts
        $postCatTech = PostCategory::query()->updateOrCreate(
            ['slug' => 'tu-van-ky-thuat'],
            [
                'name' => ['vi' => 'Tư vấn kỹ thuật thông gió HVAC', 'en' => 'HVAC Ventilation Technical Guide'],
                'description' => ['vi' => 'Cẩm nang tính toán, lắp đặt và bảo dưỡng hệ thống quạt công nghiệp.', 'en' => 'Design, installation, and maintenance guides.'],
                'is_active' => true,
            ]
        );
        $slugService->sync($postCatTech, ['vi' => 'tu-van-ky-thuat', 'en' => 'tu-van-ky-thuat']);

        $postCatProject = PostCategory::query()->updateOrCreate(
            ['slug' => 'du-an-thuc-te'],
            [
                'name' => ['vi' => 'Dự án & Công trình tiêu biểu', 'en' => 'Projects & Case Studies'],
                'description' => ['vi' => 'Các công trình thông gió nhà xưởng, trang trại Winline đã triển khai.', 'en' => 'Industrial ventilation projects completed by Winline.'],
                'is_active' => true,
            ]
        );
        $slugService->sync($postCatProject, ['vi' => 'du-an-thuc-te', 'en' => 'du-an-thuc-te']);

        $postsData = [
            [
                'category_id' => $postCatTech->id,
                'slug' => 'cach-tinh-luu-luong-gio-quat-vuong-1380',
                'title' => ['vi' => 'Cách tính toán lưu lượng gió Q = V x T và chọn số lượng quạt vuông 1380 cho nhà xưởng', 'en' => 'How to calculate airflow Q = V x T and choose 1380 exhaust fans for workshops'],
                'summary' => ['vi' => 'Hướng dẫn chi tiết công thức chuẩn HVAC tính thể tích xưởng V = D x R x C và bội số trao đổi không khí T theo từng ngành may mặc, cơ khí, kho hàng.', 'en' => 'Detailed HVAC guide for calculating workshop volume and air change rate T.'],
                'content' => ['vi' => '<p>Trong thiết kế hệ thống thông gió nhà xưởng, việc xác định chính xác lưu lượng thông gió cần thiết là bước tiên quyết để đảm bảo môi trường làm việc đạt chuẩn theo QCVN 02:2019/BYT...</p>', 'en' => '<p>In industrial workshop ventilation design, accurately determining the required airflow is essential...</p>'],
                'image_url' => 'client-assets/images/km-vuong-1380.jpg',
            ],
            [
                'category_id' => $postCatTech->id,
                'slug' => 'so-sanh-quat-cay-komasu-va-deton',
                'title' => ['vi' => 'So sánh quạt cây công nghiệp Komasu KM-750S và Deton DHF-750: Chọn loại nào tốt hơn?', 'en' => 'Comparing Komasu KM-750S and Deton DHF-750 industrial stand fans'],
                'summary' => ['vi' => 'Đánh giá độ ồn, lưu lượng gió, độ bền động cơ dây đồng và giá thành giữa 2 dòng quạt đứng công nghiệp bán chạy nhất thị trường hiện nay.', 'en' => 'Evaluation of noise level, airflow, durability and cost between Komasu and Deton.'],
                'content' => ['vi' => '<p>Komasu KM-750S và Deton DHF-750 là hai cái tên quen thuộc nhất trong các nhà xưởng sản xuất, hội trường và nhà hàng tiệc cưới lớn tại Việt Nam...</p>', 'en' => '<p>Komasu KM-750S and Deton DHF-750 are the two most popular industrial pedestal fans in Vietnam...</p>'],
                'image_url' => 'client-assets/images/km750s.jpg',
            ],
            [
                'category_id' => $postCatProject->id,
                'slug' => 'du-an-thong-gio-lam-mat-ap-suat-am-nha-may-may-bac-ninh',
                'title' => ['vi' => 'Dự án thông gió làm mát áp suất âm nhà xưởng may 3.500m² tại KCN Quế Võ, Bắc Ninh', 'en' => 'Negative pressure cooling project for 3,500m2 garment factory in Bac Ninh'],
                'summary' => ['vi' => 'Winline hoàn thiện lắp đặt 24 quạt vuông 1380 cùng 72m² tấm làm mát Cooling Pad 7090, giảm nhiệt độ trong xưởng từ 37°C xuống 28°C.', 'en' => 'Winline installed 24 square exhaust fans and 72m2 cooling pads, dropping indoor temperature from 37C to 28C.'],
                'content' => ['vi' => '<p>Nhà máy may công nghiệp với mật độ công nhân đông và nhiều máy may tỏa nhiệt đòi hỏi giải pháp làm mát vừa hiệu quả vừa tiết kiệm chi phí vận hành điện năng...</p>', 'en' => '<p>Garment factories require an efficient cooling solution that minimizes power consumption...</p>'],
                'image_url' => 'client-assets/images/air-cooler-18000.jpg',
            ],
            [
                'category_id' => $postCatTech->id,
                'slug' => 'quy-trinh-bao-duong-quat-cong-nghiep-dinh-ky',
                'title' => ['vi' => 'Quy trình bảo dưỡng quạt công nghiệp định kỳ giúp tăng tuổi thọ động cơ lên 5 năm', 'en' => 'Routine industrial fan maintenance guide to extend motor life by 5 years'],
                'summary' => ['vi' => 'Các bước tra dầu mỡ ổ bi, vệ sinh cánh quạt chống mất cân bằng động và kiểm tra độ chùng dây curoa định kỳ 6 tháng một lần.', 'en' => 'Step by step guide to lubricating bearings, cleaning blades and inspecting drive belts.'],
                'content' => ['vi' => '<p>Quạt công nghiệp hoạt động trong môi trường nhiều bụi bẩn và nhiệt độ cao cần được bảo dưỡng định kỳ để tránh nguy cơ cháy động cơ và gãy cánh...</p>', 'en' => '<p>Industrial fans operating in dusty and hot environments require routine maintenance...</p>'],
                'image_url' => 'client-assets/images/deton-lytam.jpg',
            ],
        ];

        foreach ($postsData as $p) {
            $post = Post::query()->updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'category_id' => $p['category_id'],
                    'title' => $p['title'],
                    'slug' => $p['slug'],
                    'summary' => $p['summary'],
                    'content' => $p['content'],
                    'image_url' => $p['image_url'],
                    'is_active' => true,
                    'published_at' => now(),
                ]
            );
            $slugService->sync($post, ['vi' => $p['slug'], 'en' => $p['slug']]);
        }

        // 5. Project Settings (Company legal profile)
        $companySettings = [
            'site_name' => 'Winline Việt Nam',
            'company_name' => 'Công ty TNHH Winline Việt Nam',
            'tax_number' => '0106085370',
            'hotline' => '0949.761.893',
            'warranty_phone' => '0963.230.665',
            'email' => 'Winlinevietnam@gmail.com',
            'showroom_address' => 'Số 17, Ngõ 46 Quan Nhân, Phường Thanh Xuân, TP. Hà Nội',
            'registered_address' => 'Số 7 BT6, Khu đô thị Pháp Vân - Tứ Hiệp, Phường Hoàng Liệt, Hoàng Mai, Hà Nội',
        ];

        foreach ($companySettings as $key => $val) {
            ProjectSetting::query()->updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $val, 'updated_at' => now()]
                // replaced
            );
        }

        $this->command?->info('WinlineStorefrontSeeder executed successfully!');
    }
}
