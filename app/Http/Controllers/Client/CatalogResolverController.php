<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Services\Catalog\ProductQueryService;
use App\Services\LocalizedSlugService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogResolverController extends Controller
{
    public function __construct(
        private readonly ProductController $productController,
        private readonly ProductQueryService $productQueryService,
        private readonly LocalizedSlugService $localizedSlugs,
    ) {}

    public function resolve(Request $request, string $locale, string $slug): View|\Illuminate\Http\RedirectResponse
    {
        // 0. Alias checks (Bảo toàn 100% URL hợp đồng & Excel maps)
        $aliases = [
            'danh-muc-san-pham' => null,
            'san-pham' => null,
            'danh-muc' => null,
            'tat-ca-san-pham' => null,
            'tim-kiem' => null,
            'search' => null,
            'he-thong-lam-mat-trang-trai' => 'tam-lam-mat-cooling-pad',
            'quat-thong-gio-noi-ong-cabinet-tieu-am' => 'quat-ly-tam',
            'quat-hut-cong-nghiep-vuong' => 'quat-thong-gio-vuong',
            'quat-thong-gio-cong-nghiep-tron' => 'quat-huong-truc',
            'quat-ly-tam-hut-bep' => 'quat-ly-tam',
            'quat-hut-di-dong' => 'quat-hut-xach-tay',
            'quat-cay-cn-komasu-km750s' => 'quat-cay-cong-nghiep-komasu-km-750s',
            'quat-cat-gio-nanyoo-fm-1209x-2-y' => 'quat-cat-gio-nanyoo-fm-5509z-l-y',
            'quat-tran-vinawind-5-canh-qt-1500x-dieu-khien-tu-xa' => 'quat-tran',
            'quat-hop-vinawind-qh350lp' => 'quat-hop',
            'quat-thong-gio-gan-tuong-tico-tc-20av6-1-chieu' => 'quat-thong-gio',
            'quat-san-lo-senko-sl1830' => 'quat-san',
            'dieu-hoa-di-dong-cong-nghiep-kyungjin-nd-9200' => 'may-lam-mat-cong-nghiep',
            'quat-cat-gio-dung-kyungjin-kr-1000dc' => 'quat-cat-gio',
            'du-an' => 'gioi-thieu',
        ];

        if (array_key_exists($slug, $aliases)) {
            $target = $aliases[$slug];
            if ($target === null) {
                return $this->productController->index($request, $locale);
            }
            return redirect('/' . $locale . '/' . $target, 301);
        }

        // 1. Kiểm tra Category (Cấp 1 & Cấp 2, ví dụ: 'quat-tran', 'quat-cong-nghiep')
        $category = $this->localizedSlugs->find(Category::class, $slug, $locale);
        if ($category && $category->is_active && ! $category->is_draft) {
            $catSlug = $category->canonicalSlug($locale) ?: $category->slug;
            $request->merge(['category' => $catSlug]);
            return $this->productController->index($request, $locale);
        }

        // 2. Kiểm tra Cấp 3 dạng kết hợp: {category}-{brand} (ví dụ: 'quat-tran-vinawind', 'quat-cay-panasonic')
        $brands = Brand::query()
            ->where('is_active', true)
            ->get()
            ->sortByDesc(fn ($b) => strlen($b->canonicalSlug($locale) ?: $b->slug));

        foreach ($brands as $brand) {
            $brandSlug = $brand->canonicalSlug($locale) ?: $brand->slug;
            $suffix = '-' . $brandSlug;
            if (str_ends_with($slug, $suffix)) {
                $potentialCatSlug = substr($slug, 0, -strlen($suffix));
                $cat = $this->localizedSlugs->find(Category::class, $potentialCatSlug, $locale);
                if ($cat && $cat->is_active && ! $cat->is_draft) {
                    $catCanonical = $cat->canonicalSlug($locale) ?: $cat->slug;
                    $request->merge([
                        'category' => $catCanonical,
                        'brand' => $brandSlug,
                    ]);
                    return $this->productController->index($request, $locale);
                }
            }
        }

        // 3. Kiểm tra Brand đơn lẻ (ví dụ: 'vinawind', 'panasonic')
        $brand = $this->localizedSlugs->find(Brand::class, $slug, $locale);
        if ($brand && $brand->is_active) {
            $brandSlug = $brand->canonicalSlug($locale) ?: $brand->slug;
            $request->merge(['brand' => $brandSlug]);
            return $this->productController->index($request, $locale);
        }

        // 4. Kiểm tra Product slug phẳng (ví dụ: 'km750s')
        $product = $this->productQueryService->findActiveDetail($slug);
        if ($product) {
            return $this->productController->show($request, $locale, $slug);
        }

        // 5. Kiểm tra CMS Page slug (ví dụ: 'chinh-sach-bao-hanh')
        $page = $this->localizedSlugs->find(Page::class, $slug, $locale);
        if ($page && $page->is_active && $page->published_at && ! $page->published_at->isFuture()) {
            return app(PageController::class)->show($locale, $slug);
        }

        abort(404, 'Không tìm thấy trang yêu cầu.');
    }
}
