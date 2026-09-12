<?php

namespace App\Services\Catalog;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\LocalizedSlugService;
use App\Support\FeatureGate;
use Illuminate\Database\Eloquent\Builder;

/**
 * Read side of the public catalog: the single definition of how a storefront
 * filters, sorts and eager-loads products.
 *
 * Both consumers must go through here — the JSON API in
 * {@see \App\Http\Controllers\Api\PublicController} and any same-origin Blade
 * storefront controller. A Blade controller must not reach the API over HTTP,
 * so without a shared service the two would each own a copy of this query and
 * drift apart.
 *
 * Filter keys are the public query names, so callers speak one vocabulary:
 * q, category, brand, min_price, max_price, sort_by.
 */
class ProductQueryService
{
    public const SORTS = ['latest', 'price_asc', 'price_desc'];

    public function __construct(
        private readonly LocalizedSlugService $localizedSlugs,
        private readonly FeatureGate $features,
    ) {}

    /**
     * Active products matching $filters, ready for the caller to paginate.
     *
     * @param  array<string, mixed>  $filters
     */
    public function listing(array $filters = []): Builder
    {
        $locale = app()->getLocale();
        $query = Product::query()->where('is_active', true)->with('localizedSlugs');

        if (filled($filters['category'] ?? null)) {
            $category = $this->localizedSlugs->find(Category::class, (string) $filters['category'], $locale);
            if ($category) {
                $categoryIds = array_merge([$category->id], $category->children()->pluck('id')->all());
                $query->whereIn('category_id', $categoryIds);
            } else {
                $query->where('category_id', 0);
            }
        }

        if (filled($filters['brand'] ?? null)) {
            $brandValues = is_array($filters['brand']) ? $filters['brand'] : explode(',', (string) $filters['brand']);
            $brandIds = [];
            foreach ($brandValues as $bSlug) {
                $bSlug = trim((string) $bSlug);
                if ($bSlug !== '') {
                    $brand = $this->localizedSlugs->find(Brand::class, $bSlug, $locale);
                    if ($brand) {
                        $brandIds[] = $brand->id;
                    }
                }
            }
            if (!empty($brandIds)) {
                $query->whereIn('brand_id', $brandIds);
            } else {
                $query->where('brand_id', 0);
            }
        }

        if (filled($filters['q'] ?? null)) {
            $keyword = (string) $filters['q'];
            $query->where(function (Builder $sub) use ($keyword, $locale): void {
                $sub->where("name->{$locale}", 'like', "%{$keyword}%")
                    ->orWhere("description->{$locale}", 'like', "%{$keyword}%")
                    ->orWhere('sku', 'like', "%{$keyword}%");
            });
        }

        if (filled($filters['min_price'] ?? null)) {
            $query->where('price', '>=', (float) $filters['min_price']);
        }

        if (filled($filters['max_price'] ?? null)) {
            $query->where('price', '<=', (float) $filters['max_price']);
        }

        return $this->applySort($query, $filters['sort_by'] ?? null);
    }

    /**
     * A single active product with everything a detail page renders, or null.
     */
    public function findActiveDetail(string $idOrSlug): ?Product
    {
        $product = $this->localizedSlugs->find(Product::class, $idOrSlug, app()->getLocale());

        if (! $product || ! $product->is_active) {
            return null;
        }

        return $product->load($this->detailRelations());
    }

    /**
     * Relations a product detail view needs. Kept here so the API and a Blade
     * page cannot disagree on which variants/options/reviews are visible.
     *
     * @return array<int|string, mixed>
     */
    public function detailRelations(): array
    {
        $relations = [
            'localizedSlugs',
            'category.localizedSlugs',
            'brand.localizedSlugs',
            'optionGroups.values' => fn ($query) => $query->where('is_active', true),
            'variants.optionValues.optionGroup',
            'variants' => fn ($query) => $query->where('is_active', true),
            'modelComparisonTable.items.product.localizedSlugs',
        ];

        if ($this->features->enabled('review')) {
            $relations['reviews'] = fn ($query) => $query->where('is_visible', true)->latest();
        }

        return $relations;
    }

    private function applySort(Builder $query, mixed $sortBy): Builder
    {
        return match ($sortBy) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };
    }
}
