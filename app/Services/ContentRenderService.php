<?php

namespace App\Services;

use App\Models\ModelComparisonTable;
use App\Support\HtmlSanitizer;
use Illuminate\Support\Facades\Log;

class ContentRenderService
{
    public function __construct(
        protected HtmlSanitizer $sanitizer
    ) {}

    /**
     * Parse rich text content, sanitize HTML, and expand shortcodes (such as model comparison tables).
     */
    public function render(?string $content, ?int $currentProductId = null, ?string $locale = null): string
    {
        if ($content === null || trim($content) === '') {
            return '';
        }

        $locale = $locale ?: app()->getLocale();

        // 1. Sanitize HTML to prevent XSS attacks
        $cleanHtml = $this->sanitizer->clean($content);

        // 2. Pattern to detect shortcode: [bang_so_sanh id="1"], [bang-so-sanh id=1], [model_table id="1"], etc.
        // Also captures optional surrounding <p> tags so we don't nest <div> inside <p>
        $pattern = '/(?:<p[^>]*>\s*)?\[(?:bang_so_sanh|bang-so-sanh|model_table|product_table)\s+(?:id=)?["\']?(\d+)["\']?\s*\](?:\s*<\/p>)?/ui';

        if (!preg_match_all($pattern, $cleanHtml, $matches)) {
            return $cleanHtml;
        }

        $tableIds = array_unique(array_filter(array_map('intval', $matches[1] ?? [])));

        if (empty($tableIds)) {
            return $cleanHtml;
        }

        // 3. Eager-load matching tables with items and products
        $tables = ModelComparisonTable::query()
            ->whereIn('id', $tableIds)
            ->where('is_active', true)
            ->with(['items.product.localizedSlugs'])
            ->get()
            ->keyBy('id');

        // 4. Replace each shortcode with the rendered Blade component
        return preg_replace_callback($pattern, function ($m) use ($tables, $currentProductId, $locale) {
            $id = (int) ($m[1] ?? 0);
            $table = $tables->get($id);

            if (!$table) {
                return '';
            }

            try {
                return view('client.components.model-comparison-table', [
                    'table' => $table,
                    'currentProductId' => $currentProductId,
                    'locale' => $locale,
                ])->render();
            } catch (\Throwable $e) {
                Log::warning("Failed to render model comparison table [id={$id}]: " . $e->getMessage());
                return '';
            }
        }, $cleanHtml);
    }

    /**
     * Render a single ModelComparisonTable instance to HTML.
     */
    public function renderTable(ModelComparisonTable $table, ?int $currentProductId = null, ?string $locale = null): string
    {
        if (!$table->is_active) {
            return '';
        }

        $locale = $locale ?: app()->getLocale();

        if (!$table->relationLoaded('items')) {
            $table->load(['items.product.localizedSlugs']);
        }

        return view('client.components.model-comparison-table', [
            'table' => $table,
            'currentProductId' => $currentProductId,
            'locale' => $locale,
        ])->render();
    }
}
