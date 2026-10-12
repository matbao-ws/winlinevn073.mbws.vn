<?php

namespace App\Services\Seo;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProjectSetting;

class SchemaService
{
    /**
     * Get organization settings from ProjectSetting or sensible defaults.
     */
    protected function getOrgData(): array
    {
        $siteName = ProjectSetting::query()->where('setting_key', 'site_name')->value('setting_value') ?: 'Winline Việt Nam';
        $companyName = ProjectSetting::query()->where('setting_key', 'company_name')->value('setting_value') ?: 'Công ty TNHH Winline Việt Nam';
        $taxNumber = ProjectSetting::query()->where('setting_key', 'tax_number')->value('setting_value') ?: '0106085370';
        $hotline = ProjectSetting::query()->where('setting_key', 'hotline')->value('setting_value') ?: '0949.761.893';
        $warrantyPhone = ProjectSetting::query()->where('setting_key', 'warranty_phone')->value('setting_value') ?: '0963.230.665';
        $email = ProjectSetting::query()->where('setting_key', 'email')->value('setting_value') ?: 'Winlinevietnam@gmail.com';
        $showroom = ProjectSetting::query()->where('setting_key', 'showroom_address')->value('setting_value') ?: 'Số 17, Ngõ 46 Quan Nhân, Phường Thanh Xuân, TP. Hà Nội';

        $cleanHotline = '+84' . ltrim(preg_replace('/[^0-9]/', '', $hotline), '0');
        $cleanWarranty = '+84' . ltrim(preg_replace('/[^0-9]/', '', $warrantyPhone), '0');

        return [
            'site_name' => $siteName,
            'company_name' => $companyName,
            'tax_number' => $taxNumber,
            'hotline' => $hotline,
            'clean_hotline' => $cleanHotline,
            'warranty_phone' => $warrantyPhone,
            'clean_warranty' => $cleanWarranty,
            'email' => $email,
            'address' => $showroom,
            'logo' => asset('client-assets/images/logo.png'),
            'url' => url('/'),
        ];
    }

    /**
     * Base Organization schema
     */
    public function organization(): array
    {
        $org = $this->getOrgData();

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => url('/') . '#organization',
            'name' => $org['company_name'],
            'alternateName' => $org['site_name'],
            'url' => $org['url'],
            'logo' => $org['logo'],
            'telephone' => $org['clean_hotline'],
            'email' => $org['email'],
            'taxID' => $org['tax_number'],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $org['address'],
                'addressLocality' => 'Hà Nội',
                'addressRegion' => 'Hà Nội',
                'addressCountry' => 'VN',
            ],
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'telephone' => $org['clean_hotline'],
                    'contactType' => 'sales',
                    'areaServed' => 'VN',
                    'availableLanguage' => ['vi', 'en'],
                ],
                [
                    '@type' => 'ContactPoint',
                    'telephone' => $org['clean_warranty'],
                    'contactType' => 'technical support',
                    'areaServed' => 'VN',
                    'availableLanguage' => ['vi'],
                ],
            ],
        ];
    }

    /**
     * WebSite schema with Sitelinks SearchBox
     */
    public function website(string $locale = 'vi'): array
    {
        $org = $this->getOrgData();

        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => url('/') . '#website',
            'name' => $org['site_name'],
            'url' => url('/' . $locale),
            'publisher' => [
                '@id' => url('/') . '#organization',
            ],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/' . $locale . '/tim-kiem') . '?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * Breadcrumbs schema
     */
    public function breadcrumbs(array $items): array
    {
        $elements = [];
        $position = 1;

        foreach ($items as $item) {
            $elements[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => (string) ($item['name'] ?? ''),
                'item' => (string) ($item['url'] ?? ''),
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $elements,
        ];
    }

    /**
     * Schema for Homepage (Organization + WebSite)
     */
    public function forHome(string $locale = 'vi'): string
    {
        $schemas = [
            $this->organization(),
            $this->website($locale),
        ];

        return $this->toScriptTag($schemas);
    }

    /**
     * Schema for Category / Collection Page
     */
    public function forCategory(?Category $category, $products = null, ?Brand $brand = null, string $locale = 'vi'): string
    {
        $schemas = [];

        // 1. Breadcrumbs
        $crumbs = [
            ['name' => 'Trang chủ', 'url' => url('/' . $locale)],
        ];

        if ($category && $category->parent) {
            $parentSlug = $category->parent->canonicalSlug($locale) ?: $category->parent->slug;
            $crumbs[] = [
                'name' => $category->parent->getTranslation('name', $locale),
                'url' => url('/' . $locale . '/' . $parentSlug),
            ];
        }

        if ($category) {
            $catSlug = $category->canonicalSlug($locale) ?: $category->slug;
            $crumbs[] = [
                'name' => $category->getTranslation('name', $locale),
                'url' => url('/' . $locale . '/' . $catSlug),
            ];
        } else {
            $crumbs[] = [
                'name' => 'Danh mục sản phẩm',
                'url' => url('/' . $locale . '/danh-muc-san-pham'),
            ];
        }

        if ($brand) {
            $crumbs[] = [
                'name' => $brand->getTranslation('name', $locale),
                'url' => url('/' . $locale . '/' . ($category ? $category->slug : 'danh-muc-san-pham') . '?brand=' . $brand->slug),
            ];
        }

        $schemas[] = $this->breadcrumbs($crumbs);

        // 2. CollectionPage / ItemList
        $pageName = 'Danh mục sản phẩm';
        if ($category && $brand) {
            $pageName = $category->getTranslation('name', $locale) . ' ' . $brand->getTranslation('name', $locale);
        } elseif ($category) {
            $pageName = $category->getTranslation('name', $locale);
        } elseif ($brand) {
            $pageName = 'Quạt ' . $brand->getTranslation('name', $locale);
        }

        $collectionUrl = $category
            ? url('/' . $locale . '/' . ($category->canonicalSlug($locale) ?: $category->slug))
            : url('/' . $locale . '/danh-muc-san-pham');

        $collectionSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            '@id' => $collectionUrl . '#collection',
            'name' => $pageName . ' | Winline Việt Nam',
            'url' => $collectionUrl,
            'description' => $category ? ($category->meta_description ?: $category->name) : 'Danh mục sản phẩm Winline',
        ];

        if ($products && count($products) > 0) {
            $itemListElements = [];
            $pos = 1;
            foreach ($products as $p) {
                $pSlug = $p->canonicalSlug($locale) ?: $p->slug;
                $pUrl = route('client.products.detail', ['locale' => $locale, 'slug' => $pSlug]);
                $pImg = $p->image_url ? (str_starts_with($p->image_url, 'http') ? $p->image_url : asset($p->image_url)) : asset('client-assets/images/placeholder.png');

                $itemListElements[] = [
                    '@type' => 'ListItem',
                    'position' => $pos++,
                    'name' => $p->getTranslation('name', $locale),
                    'url' => $pUrl,
                    'image' => $pImg,
                ];
            }

            $collectionSchema['mainEntity'] = [
                '@type' => 'ItemList',
                'numberOfItems' => count($products),
                'itemListElement' => $itemListElements,
            ];
        }

        $schemas[] = $collectionSchema;

        return $this->toScriptTag($schemas);
    }

    /**
     * Schema for Single Product Detail
     */
    public function forProduct(Product $product, string $locale = 'vi'): string
    {
        $schemas = [];
        $slug = $product->canonicalSlug($locale) ?: $product->slug;
        $productUrl = route('client.products.detail', ['locale' => $locale, 'slug' => $slug]);

        // 1. Breadcrumbs
        $crumbs = [
            ['name' => 'Trang chủ', 'url' => url('/' . $locale)],
        ];

        if ($product->category) {
            if ($product->category->parent) {
                $pCatSlug = $product->category->parent->canonicalSlug($locale) ?: $product->category->parent->slug;
                $crumbs[] = [
                    'name' => $product->category->parent->getTranslation('name', $locale),
                    'url' => url('/' . $locale . '/' . $pCatSlug),
                ];
            }
            $catSlug = $product->category->canonicalSlug($locale) ?: $product->category->slug;
            $crumbs[] = [
                'name' => $product->category->getTranslation('name', $locale),
                'url' => url('/' . $locale . '/' . $catSlug),
            ];
        }

        $crumbs[] = [
            'name' => $product->getTranslation('name', $locale),
            'url' => $productUrl,
        ];

        $schemas[] = $this->breadcrumbs($crumbs);

        // 2. Images
        $images = [];
        if ($product->image_url) {
            $images[] = str_starts_with($product->image_url, 'http') ? $product->image_url : asset($product->image_url);
        }
        foreach ($product->images as $galleryImg) {
            if ($galleryImg->image_url) {
                $images[] = str_starts_with($galleryImg->image_url, 'http') ? $galleryImg->image_url : asset($galleryImg->image_url);
            }
        }
        if (empty($images)) {
            $images[] = asset('client-assets/images/placeholder.png');
        }

        // 3. Description
        $descRaw = $product->getTranslation('short_description', $locale) ?: $product->getTranslation('description', $locale);
        $cleanDesc = trim(preg_replace('/\s+/', ' ', strip_tags((string) $descRaw)));
        if (empty($cleanDesc)) {
            $cleanDesc = $product->getTranslation('name', $locale) . ' chính hãng tại Winline Việt Nam. Bảo hành chính hãng, CO/CQ đầy đủ.';
        }

        // 4. SKU & MPN
        $sku = $product->sku ?: 'WINLINE-' . $product->id;

        // 5. Brand
        $brandName = $product->brand?->getTranslation('name', $locale) ?: 'Winline';

        // 6. Offer
        $price = (float) $product->price;
        $inStock = ($product->stock_quantity > 0) || (!$product->manage_stock);

        $offer = [
            '@type' => 'Offer',
            'url' => $productUrl,
            'priceCurrency' => 'VND',
            'price' => (string) round($price),
            'priceValidUntil' => date('Y-12-31', strtotime('+1 year')),
            'itemCondition' => 'https://schema.org/NewCondition',
            'availability' => $inStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'seller' => [
                '@type' => 'Organization',
                'name' => 'Winline Việt Nam',
                'url' => url('/'),
            ],
        ];

        $productSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            '@id' => $productUrl . '#product',
            'name' => $product->getTranslation('name', $locale),
            'url' => $productUrl,
            'image' => count($images) === 1 ? $images[0] : array_values(array_unique($images)),
            'description' => $cleanDesc,
            'sku' => $sku,
            'mpn' => $sku,
            'brand' => [
                '@type' => 'Brand',
                'name' => $brandName,
            ],
            'offers' => $offer,
        ];

        // 7. Specifications (Additional properties)
        $specs = [];
        if (!empty($product->airflow)) {
            $specs[] = ['@type' => 'PropertyValue', 'name' => 'Lưu lượng gió', 'value' => $product->airflow . ' m³/h'];
        }
        if (!empty($product->power)) {
            $specs[] = ['@type' => 'PropertyValue', 'name' => 'Công suất', 'value' => (string) $product->power];
        }
        if (!empty($product->voltage)) {
            $specs[] = ['@type' => 'PropertyValue', 'name' => 'Điện áp', 'value' => (string) $product->voltage];
        }
        if (!empty($product->size_display)) {
            $specs[] = ['@type' => 'PropertyValue', 'name' => 'Kích thước', 'value' => (string) $product->size_display];
        }
        if (!empty($product->hole_size)) {
            $specs[] = ['@type' => 'PropertyValue', 'name' => 'Kích thước lỗ khoét', 'value' => (string) $product->hole_size];
        }
        if (!empty($product->fan_type)) {
            $specs[] = ['@type' => 'PropertyValue', 'name' => 'Loại quạt', 'value' => (string) $product->fan_type];
        }

        if (!empty($specs)) {
            $productSchema['additionalProperty'] = $specs;
        }

        // 8. Reviews / AggregateRating (Only if actual approved reviews exist)
        $approvedReviews = \App\Models\Review::query()
            ->where('product_id', $product->id)
            ->where('is_visible', true)
            ->get();

        if ($approvedReviews->count() > 0) {
            $avgRating = round($approvedReviews->avg('rating'), 1);
            $productSchema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => (string) $avgRating,
                'reviewCount' => (string) $approvedReviews->count(),
                'bestRating' => '5',
                'worstRating' => '1',
            ];

            $reviewItems = [];
            foreach ($approvedReviews->take(5) as $rev) {
                $reviewItems[] = [
                    '@type' => 'Review',
                    'author' => [
                        '@type' => 'Person',
                        'name' => $rev->customer_name ?: 'Khách hàng',
                    ],
                    'datePublished' => $rev->created_at?->format('Y-m-d') ?: date('Y-m-d'),
                    'reviewBody' => $rev->comment ?: '',
                    'reviewRating' => [
                        '@type' => 'Rating',
                        'ratingValue' => (string) $rev->rating,
                        'bestRating' => '5',
                        'worstRating' => '1',
                    ],
                ];
            }
            $productSchema['review'] = $reviewItems;
        }

        $schemas[] = $productSchema;

        return $this->toScriptTag($schemas);
    }

    /**
     * Schema for News / Article Detail
     */
    public function forArticle(Post $post, string $locale = 'vi'): string
    {
        $schemas = [];
        $slug = $post->canonicalSlug($locale) ?: $post->slug;
        $postUrl = route('client.news.detail', ['locale' => $locale, 'slug' => $slug]);

        // 1. Breadcrumbs
        $crumbs = [
            ['name' => 'Trang chủ', 'url' => url('/' . $locale)],
            ['name' => 'Tin tức & Cẩm nang', 'url' => route('client.news', ['locale' => $locale])],
        ];

        if ($post->category) {
            $crumbs[] = [
                'name' => $post->category->name,
                'url' => route('client.news', ['locale' => $locale, 'category' => $post->category->slug]),
            ];
        }

        $crumbs[] = [
            'name' => $post->getTranslation('title', $locale),
            'url' => $postUrl,
        ];

        $schemas[] = $this->breadcrumbs($crumbs);

        // 2. Article
        $image = $post->image_url ? (str_starts_with($post->image_url, 'http') ? $post->image_url : asset($post->image_url)) : asset('client-assets/images/placeholder.png');
        $desc = trim(preg_replace('/\s+/', ' ', strip_tags((string) ($post->getTranslation('summary', $locale) ?: $post->getTranslation('content', $locale)))));

        $articleSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            '@id' => $postUrl . '#article',
            'headline' => $post->getTranslation('title', $locale),
            'description' => mb_substr($desc, 0, 250),
            'image' => [$image],
            'datePublished' => $post->published_at ? $post->published_at->toIso8601String() : ($post->created_at ? $post->created_at->toIso8601String() : date('c')),
            'dateModified' => $post->updated_at ? $post->updated_at->toIso8601String() : date('c'),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $postUrl,
            ],
            'author' => [
                '@type' => 'Organization',
                'name' => 'Ban biên tập Winline Việt Nam',
                'url' => url('/'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Công ty TNHH Winline Việt Nam',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('client-assets/images/logo.png'),
                ],
            ],
        ];

        $schemas[] = $articleSchema;

        return $this->toScriptTag($schemas);
    }

    /**
     * Schema for News Listing
     */
    public function forNewsIndex($posts = null, ?PostCategory $category = null, string $locale = 'vi'): string
    {
        $schemas = [];

        $crumbs = [
            ['name' => 'Trang chủ', 'url' => url('/' . $locale)],
            ['name' => 'Tin tức & Cẩm nang HVAC', 'url' => route('client.news', ['locale' => $locale])],
        ];

        if ($category) {
            $crumbs[] = [
                'name' => $category->name,
                'url' => route('client.news', ['locale' => $locale, 'category' => $category->slug]),
            ];
        }

        $schemas[] = $this->breadcrumbs($crumbs);

        return $this->toScriptTag($schemas);
    }

    /**
     * Helper to render array of schemas as <script type="application/ld+json">
     */
    protected function toScriptTag(array $schemas): string
    {
        if (empty($schemas)) {
            return '';
        }

        $html = '';
        foreach ($schemas as $schema) {
            $json = json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            $html .= '<script type="application/ld+json">' . PHP_EOL . $json . PHP_EOL . '</script>' . PHP_EOL;
        }

        return $html;
    }
}
