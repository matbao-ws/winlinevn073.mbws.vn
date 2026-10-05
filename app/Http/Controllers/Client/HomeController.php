<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Services\Catalog\ProductQueryService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly ProductQueryService $products,
    ) {}

    public function index(string $locale): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = $this->products
            ->listing(['sort_by' => 'latest'])
            ->where('is_featured', true)
            ->take(5)
            ->get();

        if ($featuredProducts->count() < 5) {
            $fallback = $this->products
                ->listing(['sort_by' => 'latest'])
                ->take(5)
                ->get();
            $featuredProducts = $featuredProducts->merge($fallback)->unique('id')->take(5);
        }

        $featuredIds = $featuredProducts->pluck('id')->all();

        $recentProducts = $this->products
            ->listing(['sort_by' => 'latest'])
            ->whereNotIn('id', $featuredIds)
            ->take(5)
            ->get();

        if ($recentProducts->count() < 5) {
            $recentProducts = $this->products
                ->listing(['sort_by' => 'price_desc'])
                ->take(5)
                ->get();
        }

        // Residential products (Quạt điện dân dụng)
        $residentialCat = Category::query()->where('slug', 'quat-dan-dung')->first();
        $residentialProducts = collect();
        if ($residentialCat) {
            $catIds = array_merge([$residentialCat->id], $residentialCat->children()->pluck('id')->all());
            $residentialProducts = \App\Models\Product::query()
                ->where('is_active', true)
                ->whereIn('category_id', $catIds)
                ->with('localizedSlugs')
                ->take(3)
                ->get();
        }
        if ($residentialProducts->count() < 3) {
            $residentialProducts = $this->products->listing()->take(3)->get();
        }

        // Industrial products (Quạt công nghiệp)
        $industrialCat = Category::query()->where('slug', 'quat-cong-nghiep')->first();
        $industrialProducts = collect();
        if ($industrialCat) {
            $catIds = array_merge([$industrialCat->id], $industrialCat->children()->pluck('id')->all());
            $industrialProducts = \App\Models\Product::query()
                ->where('is_active', true)
                ->whereIn('category_id', $catIds)
                ->with('localizedSlugs')
                ->take(3)
                ->get();
        }
        if ($industrialProducts->count() < 3) {
            $industrialProducts = $this->products->listing()->skip(3)->take(3)->get();
            if ($industrialProducts->count() < 3) {
                $industrialProducts = $this->products->listing()->take(3)->get();
            }
        }

        $brands = Brand::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $posts = Post::query()
            ->where('is_active', true)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('client.pages.home', [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'recentProducts' => $recentProducts,
            'residentialProducts' => $residentialProducts,
            'industrialProducts' => $industrialProducts,
            'brands' => $brands,
            'posts' => $posts,
        ]);
    }
}
