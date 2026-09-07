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
            ->take(8)
            ->get();

        if ($featuredProducts->isEmpty()) {
            $featuredProducts = $this->products
                ->listing(['sort_by' => 'latest'])
                ->take(8)
                ->get();
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
            'brands' => $brands,
            'posts' => $posts,
        ]);
    }
}
