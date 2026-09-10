<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\Catalog\ProductQueryService;
use App\Services\LocalizedSlugService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductQueryService $productQueryService,
        private readonly LocalizedSlugService $localizedSlugs,
    ) {}

    public function index(Request $request, string $locale): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        $brands = Brand::query()
            ->where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        $filters = $request->only(['q', 'category', 'brand', 'min_price', 'max_price', 'sort_by']);

        $products = $this->productQueryService
            ->listing($filters)
            ->paginate(16)
            ->withQueryString();

        $currentCategory = null;
        if (!empty($filters['category'])) {
            $currentCategory = $this->localizedSlugs->find(Category::class, (string) $filters['category'], $locale);
        }

        $currentBrand = null;
        if (!empty($filters['brand']) && is_string($filters['brand']) && !str_contains($filters['brand'], ',')) {
            $currentBrand = $this->localizedSlugs->find(Brand::class, (string) $filters['brand'], $locale);
        }

        // Brands relevant to this category for the top quick filter bar (Dien May Xanh style)
        $categoryBrands = $brands;
        if ($currentCategory) {
            $catIds = array_merge([$currentCategory->id], $currentCategory->children()->pluck('id')->all());
            $catBrandIds = Product::query()
                ->where('is_active', true)
                ->whereIn('category_id', $catIds)
                ->whereNotNull('brand_id')
                ->distinct()
                ->pluck('brand_id')
                ->all();
            if (!empty($catBrandIds)) {
                $categoryBrands = $brands->whereIn('id', $catBrandIds);
            }
        }

        return view('client.pages.products', [
            'categories' => $categories,
            'brands' => $brands,
            'categoryBrands' => $categoryBrands,
            'products' => $products,
            'filters' => $filters,
            'currentCategory' => $currentCategory,
            'currentBrand' => $currentBrand,
        ]);
    }

    public function count(Request $request): \Illuminate\Http\JsonResponse
    {
        $filters = $request->only(['q', 'category', 'brand', 'min_price', 'max_price', 'sort_by']);
        $count = $this->productQueryService->listing($filters)->count();
        return response()->json(['count' => $count]);
    }

    public function searchLive(Request $request): \Illuminate\Http\JsonResponse
    {
        $q = trim((string) $request->input('q', ''));
        if (mb_strlen($q) < 2) {
            return response()->json(['products' => []]);
        }
        $locale = app()->getLocale();
        $products = $this->productQueryService->listing(['q' => $q])
            ->take(8)
            ->get()
            ->map(function ($p) use ($locale) {
                return [
                    'id' => $p->id,
                    'name' => $p->getTranslation('name', $locale),
                    'sku' => $p->sku,
                    'price' => number_format((float) $p->price, 0, ',', '.') . '₫',
                    'image' => $p->imageUrl('thumb') ?: asset('client-assets/images/km750s.jpg'),
                    'url' => route('client.products.detail', ['slug' => $p->canonicalSlug($locale)]),
                    'brand' => $p->brand?->getTranslation('name', $locale),
                ];
            });
        return response()->json(['products' => $products]);
    }

    public function show(Request $request, string $locale, string $slug): View
    {
        $product = $this->productQueryService->findActiveDetail($slug);

        if (!$product) {
            abort(404, 'Không tìm thấy sản phẩm.');
        }

        $relatedProducts = $this->productQueryService
            ->listing(['category' => $product->category?->canonicalSlug($locale)])
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        if ($relatedProducts->isEmpty()) {
            $relatedProducts = $this->productQueryService
                ->listing(['sort_by' => 'latest'])
                ->where('id', '!=', $product->id)
                ->take(4)
                ->get();
        }

        return view('client.pages.product-detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
