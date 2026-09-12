<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ModelComparisonItem;
use App\Models\ModelComparisonTable;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ModelComparisonTableController extends Controller
{
    public function index(Request $request, ?string $locale = null): View
    {
        $search = $request->query('search');

        $tables = ModelComparisonTable::query()
            ->withCount('items')
            ->when($search, function ($query, $term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('title', 'like', "%{$term}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.model_tables.index', [
            'tables' => $tables,
            'search' => $search,
        ]);
    }

    public function create(?string $locale = null): View
    {
        $table = new ModelComparisonTable([
            'columns' => [
                'Điện áp (V/Hz)',
                'Công suất (W)',
                'Lưu lượng gió (m³/h)',
                'Vận tốc gió (m/s)',
                'Độ ồn (dB)',
                'Số Động cơ (Cái)',
                'Kích thước quạt (mm)',
                'Cân nặng (kg - net)',
            ],
            'show_price' => true,
            'show_action_btn' => true,
            'is_active' => true,
        ]);

        return view('admin.model_tables.create', [
            'table' => $table,
            'items' => collect(),
        ]);
    }

    public function store(Request $request, ?string $locale = null): RedirectResponse
    {
        $validated = $this->validateTable($request);

        DB::transaction(function () use ($validated, $request) {
            $table = ModelComparisonTable::create([
                'name' => $validated['name'],
                'title' => $validated['title'],
                'subtitle' => $validated['subtitle'] ?? null,
                'columns' => array_values(array_filter($validated['columns'] ?? [])),
                'show_price' => $request->boolean('show_price', true),
                'show_action_btn' => $request->boolean('show_action_btn', true),
                'is_active' => $request->boolean('is_active', true),
            ]);

            $this->syncItems($table, $request->input('items', []));
        });

        return redirect()
            ->route('admin.model-tables.index', ['locale' => $locale ?: app()->getLocale() ?: 'vi'])
            ->with('success', 'Bảng so sánh model đã được tạo thành công.');
    }

    public function edit(string $locale, ModelComparisonTable $model_table): View
    {
        $model_table->load(['items.product']);

        return view('admin.model_tables.edit', [
            'table' => $model_table,
            'items' => $model_table->items,
        ]);
    }

    public function update(Request $request, string $locale, ModelComparisonTable $model_table): RedirectResponse
    {
        $validated = $this->validateTable($request);

        DB::transaction(function () use ($model_table, $validated, $request) {
            $model_table->update([
                'name' => $validated['name'],
                'title' => $validated['title'],
                'subtitle' => $validated['subtitle'] ?? null,
                'columns' => array_values(array_filter($validated['columns'] ?? [])),
                'show_price' => $request->boolean('show_price', true),
                'show_action_btn' => $request->boolean('show_action_btn', true),
                'is_active' => $request->boolean('is_active', true),
            ]);

            $this->syncItems($model_table, $request->input('items', []));
        });

        return redirect()
            ->route('admin.model-tables.index', ['locale' => $locale ?: app()->getLocale() ?: 'vi'])
            ->with('success', 'Bảng so sánh model đã được cập nhật.');
    }

    public function destroy(string $locale, ModelComparisonTable $model_table): RedirectResponse
    {
        $model_table->delete();

        return redirect()
            ->route('admin.model-tables.index', ['locale' => $locale ?: app()->getLocale() ?: 'vi'])
            ->with('success', 'Bảng so sánh model đã được xóa.');
    }

    public function duplicate(string $locale, ModelComparisonTable $model_table): RedirectResponse
    {
        DB::transaction(function () use ($model_table) {
            $model_table->load('items');

            $newTable = $model_table->replicate([
                'created_at',
                'updated_at',
            ]);
            $newTable->name = $model_table->name . ' (Bản sao)';
            $newTable->save();

            foreach ($model_table->items as $item) {
                $newItem = $item->replicate([
                    'created_at',
                    'updated_at',
                ]);
                $newItem->table_id = $newTable->id;
                $newItem->save();
            }
        });

        return redirect()
            ->route('admin.model-tables.index', ['locale' => $locale ?: app()->getLocale() ?: 'vi'])
            ->with('success', 'Đã nhân bản bảng so sánh model thành công.');
    }

    public function searchProducts(Request $request, ?string $locale = null): JsonResponse
    {
        $term = trim((string) $request->query('q', ''));

        if (mb_strlen($term) < 1) {
            return response()->json(['results' => []]);
        }

        $locale = $locale ?: app()->getLocale() ?: 'vi';

        $products = Product::query()
            ->where('is_active', true)
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('sku', 'like', "%{$term}%")
                    ->orWhere('slug', 'like', "%{$term}%");
            })
            ->take(20)
            ->get();

        $results = $products->map(function (Product $product) use ($locale) {
            $priceText = $product->price > 0 
                ? number_format((float) $product->price, 0, ',', '.') . ' đ'
                : 'Liên hệ';

            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku ?: '—',
                'price' => (float) $product->price,
                'price_formatted' => $priceText,
                'url' => route('client.products.detail', ['locale' => $locale, 'slug' => $product->canonicalSlug($locale)]),
                'image_url' => $product->primary_image_url ?: asset('client-assets/images/placeholder.png'),
            ];
        });

        return response()->json(['results' => $results]);
    }

    protected function validateTable(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'columns' => 'required|array|min:1',
            'columns.*' => 'required|string|max:100',
            'show_price' => 'nullable|boolean',
            'show_action_btn' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Vui lòng nhập tên quản trị cho bảng.',
            'title.required' => 'Vui lòng nhập tiêu đề hiển thị ngoài web.',
            'columns.required' => 'Vui lòng cấu hình ít nhất một cột thông số.',
            'columns.*.required' => 'Tên cột không được để trống.',
        ]);
    }

    protected function syncItems(ModelComparisonTable $table, array $rawItems): void
    {
        $table->items()->delete();

        $sortOrder = 0;

        foreach ($rawItems as $raw) {
            $modelName = trim($raw['model_name'] ?? '');
            if ($modelName === '') {
                continue;
            }

            $productId = !empty($raw['product_id']) ? (int) $raw['product_id'] : null;
            $customPrice = !empty($raw['custom_price']) ? (float) $raw['custom_price'] : null;
            $customUrl = !empty($raw['custom_url']) ? trim($raw['custom_url']) : null;
            $specs = is_array($raw['specs'] ?? null) ? $raw['specs'] : [];

            ModelComparisonItem::create([
                'table_id' => $table->id,
                'product_id' => $productId,
                'model_name' => $modelName,
                'specs' => $specs,
                'custom_price' => $customPrice,
                'custom_url' => $customUrl,
                'sort_order' => $sortOrder++,
            ]);
        }
    }
}
