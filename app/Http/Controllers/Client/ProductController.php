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
        if (!empty($filters['brand'])) {
            $currentBrand = $this->localizedSlugs->find(Brand::class, (string) $filters['brand'], $locale);
        }

        return view('client.pages.products', [
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products,
            'filters' => $filters,
            'currentCategory' => $currentCategory,
            'currentBrand' => $currentBrand,
        ]);
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
