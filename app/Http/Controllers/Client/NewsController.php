<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Services\LocalizedSlugService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(
        private readonly LocalizedSlugService $localizedSlugs,
    ) {}

    public function index(Request $request, string $locale): View
    {
        $categorySlug = $request->query('category');
        $query = Post::query()->where('is_active', true)->with('category');

        if ($categorySlug) {
            $cat = $this->localizedSlugs->find(PostCategory::class, (string) $categorySlug, $locale);
            if ($cat) {
                $query->where('category_id', $cat->id);
            }
        }

        $posts = $query->latest('published_at')->paginate(9)->withQueryString();
        $categories = PostCategory::query()->where('is_active', true)->get();
        $recentPosts = Post::query()->where('is_active', true)->latest('published_at')->take(5)->get();

        return view('client.pages.news', [
            'posts' => $posts,
            'categories' => $categories,
            'recentPosts' => $recentPosts,
            'currentCategorySlug' => $categorySlug,
        ]);
    }

    public function show(string $locale, string $slug): View
    {
        $post = $this->localizedSlugs->find(Post::class, $slug, $locale);

        if (!$post || !$post->is_active) {
            abort(404, 'Không tìm thấy bài viết.');
        }

        $relatedPosts = Post::query()
            ->where('is_active', true)
            ->where('id', '!=', $post->id)
            ->when($post->category_id, fn ($q) => $q->where('category_id', $post->category_id))
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('client.pages.news-detail', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
