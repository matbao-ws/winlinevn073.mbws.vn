<?php

namespace App\Services\HVAC;

use App\Models\Product;
use Illuminate\Support\Collection;

class FanCalculationService
{
    public const COOLING_PAD_VELOCITY = 9000; // 9.000 m3/h per m2 pad area

    public const SPACE_TYPES_PHU_LUC_G = [
        'cong_so' => ['name' => 'Công sở, văn phòng', 'ach' => 6],
        'nha_o' => ['name' => 'Nhà ở, phòng ngủ', 'ach' => 3],
        'nha_hang' => ['name' => 'Phòng ăn khách sạn, căng tin', 'ach' => 10],
        'cua_hang' => ['name' => 'Cửa hàng, siêu thị', 'ach' => 6],
        'xi_nghiep' => ['name' => 'Xí nghiệp, nhà công nghiệp', 'ach' => 6],
        'phong_hoc' => ['name' => 'Phòng học', 'ach' => 8],
        'phong_thi_nghiem' => ['name' => 'Phòng thí nghiệm', 'ach' => 11],
        'thu_vien' => ['name' => 'Thư viện', 'ach' => 6],
        'benh_vien' => ['name' => 'Bệnh viện', 'ach' => 8],
        'rap_chieu_bong' => ['name' => 'Nhà hát, rạp chiếu bóng', 'ach' => 8],
        'sanh' => ['name' => 'Sảnh, hành lang, cầu thang', 'ach' => 4],
        've_sinh' => ['name' => 'Phòng tắm, phòng vệ sinh (WC)', 'ach' => 10],
        'bep' => ['name' => 'Phòng bếp (thương nghiệp, xí nghiệp)', 'ach' => 20],
        'gara' => ['name' => 'Ga ra ô tô', 'ach' => 6],
        'may_bom' => ['name' => 'Phòng máy bơm cấp thoát nước', 'ach' => 8],
    ];

    public const STANDARD_COOLING_PADS = [
        [
            'sku' => 'PAD-1800X600-BR',
            'name' => 'Tấm làm mát Cooling Pad Nâu 1800x600x150mm',
            'length' => 1.8,
            'width' => 0.6,
            'thickness' => 150,
            'unit_price' => 480000,
            'image' => 'client-assets/images/cooling-pad.jpg',
        ],
        [
            'sku' => 'PAD-1800X600-GR',
            'name' => 'Tấm làm mát chống rêu Cooling Pad 7090 (1800x600x150mm)',
            'length' => 1.8,
            'width' => 0.6,
            'thickness' => 150,
            'unit_price' => 550000,
            'image' => 'client-assets/images/cooling-pad.jpg',
        ],
        [
            'sku' => 'PAD-2000X600-BR',
            'name' => 'Tấm làm mát Cooling Pad Nâu 2000x600x150mm',
            'length' => 2.0,
            'width' => 0.6,
            'thickness' => 150,
            'unit_price' => 520000,
            'image' => 'client-assets/images/cooling-pad.jpg',
        ],
        [
            'sku' => 'PAD-1500X600-BR',
            'name' => 'Tấm làm mát Cooling Pad Nâu 1500x600x150mm',
            'length' => 1.5,
            'width' => 0.6,
            'thickness' => 150,
            'unit_price' => 420000,
            'image' => 'client-assets/images/cooling-pad.jpg',
        ],
        [
            'sku' => 'PAD-1800X1500',
            'name' => 'Cụm tấm làm mát xưởng 1800x1500x150mm',
            'length' => 1.8,
            'width' => 1.5,
            'thickness' => 150,
            'unit_price' => 1350000,
            'image' => 'client-assets/images/cooling-pad.jpg',
        ],
        [
            'sku' => 'PAD-1800X1800',
            'name' => 'Cụm tấm làm mát xưởng 1800x1800x150mm',
            'length' => 1.8,
            'width' => 1.8,
            'thickness' => 150,
            'unit_price' => 1620000,
            'image' => 'client-assets/images/cooling-pad.jpg',
        ],
        [
            'sku' => 'PAD-2400X1800',
            'name' => 'Cụm tấm làm mát xưởng 2400x1800x150mm',
            'length' => 2.4,
            'width' => 1.8,
            'thickness' => 150,
            'unit_price' => 2160000,
            'image' => 'client-assets/images/cooling-pad.jpg',
        ],
        [
            'sku' => 'PAD-3600X1800',
            'name' => 'Cụm tấm làm mát xưởng 3600x1800x150mm',
            'length' => 3.6,
            'width' => 1.8,
            'thickness' => 150,
            'unit_price' => 3240000,
            'image' => 'client-assets/images/cooling-pad.jpg',
        ],
    ];

    /**
     * Compute requirements for Tab 1: Thông gió - Hút khí
     */
    public function computeTab1(float $area, float $height, float $boiso, ?string $voltage = null): array
    {
        $area = max(0.0, $area);
        $height = max(0.0, $height);
        $boiso = max(0.0, $boiso);

        $volume = round($area * $height, 2);
        $requiredFlow = round($volume * $boiso, 0);

        return [
            'tab' => 'thong-gio-hut-khi',
            'area' => $area,
            'height' => $height,
            'volume' => $volume,
            'boiso' => $boiso,
            'required_airflow' => $requiredFlow,
            'voltage' => $voltage ?: 'all',
        ];
    }

    /**
     * Compute requirements for Tab 2: Làm mát bằng Cooling Pad
     */
    public function computeTab2(float $area, float $height, float $boiso = 60.0, ?string $voltage = null): array
    {
        $area = max(0.0, $area);
        $height = max(0.0, $height);
        $boiso = ($boiso > 0) ? $boiso : 60.0;

        $volume = round($area * $height, 2);
        $requiredFlow = round($volume * $boiso, 0);
        $nominalPadArea = ($requiredFlow > 0) ? round($requiredFlow / self::COOLING_PAD_VELOCITY, 2) : 0.0;

        return [
            'tab' => 'cooling-pad',
            'area' => $area,
            'height' => $height,
            'volume' => $volume,
            'boiso' => $boiso,
            'required_airflow' => $requiredFlow,
            'nominal_pad_area' => $nominalPadArea,
            'voltage' => $voltage ?: 'all',
        ];
    }

    /**
     * Compute requirements for Tab 3: Thông gió văn phòng, phòng bếp & WC
     */
    public function computeTab3(float $area, float $height, string $spaceType = 'cong_so', ?string $voltage = null): array
    {
        $area = max(0.0, $area);
        $height = max(0.0, $height);
        $typeInfo = self::SPACE_TYPES_PHU_LUC_G[$spaceType] ?? self::SPACE_TYPES_PHU_LUC_G['cong_so'];
        $boiso = (float) $typeInfo['ach'];

        $volume = round($area * $height, 2);
        $requiredFlow = round($volume * $boiso, 0);

        return [
            'tab' => 'thong-gio-phong',
            'area' => $area,
            'height' => $height,
            'space_type' => $spaceType,
            'space_name' => $typeInfo['name'],
            'volume' => $volume,
            'boiso' => $boiso,
            'required_airflow' => $requiredFlow,
            'voltage' => $voltage ?: 'all',
        ];
    }

    /**
     * Balance and calculate summary for up to 3 selected products
     */
    public function balanceSelection(float $requiredFlow, array $items): array
    {
        if (empty($items)) {
            return [
                'items' => [],
                'total_actual_airflow' => 0,
                'delta_flow' => -$requiredFlow,
                'delta_percent' => -100.0,
                'is_in_tolerance' => false,
                'total_price' => 0,
                'status_label' => 'Chưa chọn sản phẩm',
                'status_class' => 'warning',
            ];
        }

        // Keep maximum 3 items
        $items = array_slice($items, 0, 3);

        // Find primary item index (default to 0)
        $primaryIndex = 0;
        foreach ($items as $idx => $item) {
            if (!empty($item['is_primary'])) {
                $primaryIndex = $idx;
                break;
            }
        }

        // Sum other items' airflow
        $otherFlow = 0;
        foreach ($items as $idx => &$item) {
            $item['airflow'] = (float) ($item['airflow'] ?? 0);
            $item['unit_price'] = (float) ($item['unit_price'] ?? 0);

            if ($idx !== $primaryIndex) {
                $item['is_primary'] = false;
                $item['quantity'] = max(1, (int) ($item['quantity'] ?? 1));
                $otherFlow += $item['quantity'] * $item['airflow'];
            }
        }
        unset($item);

        // Calculate primary item quantity
        $primaryAirflow = $items[$primaryIndex]['airflow'];
        if ($primaryAirflow > 0 && $requiredFlow > 0) {
            $neededForPrimary = max(0, $requiredFlow - $otherFlow);
            $primaryQty = (int) ceil($neededForPrimary / $primaryAirflow);
            $items[$primaryIndex]['quantity'] = max(1, $primaryQty);
        } else {
            $items[$primaryIndex]['quantity'] = max(1, (int) ($items[$primaryIndex]['quantity'] ?? 1));
        }
        $items[$primaryIndex]['is_primary'] = true;

        // Calculate totals
        $totalFlow = 0;
        $totalPrice = 0;
        foreach ($items as &$item) {
            $item['total_airflow'] = $item['quantity'] * $item['airflow'];
            $item['total_price'] = $item['quantity'] * $item['unit_price'];
            $totalFlow += $item['total_airflow'];
            $totalPrice += $item['total_price'];
        }
        unset($item);

        $deltaFlow = $totalFlow - $requiredFlow;
        $deltaPercent = ($requiredFlow > 0) ? round(($deltaFlow / $requiredFlow) * 100, 2) : 0.0;
        $isInTolerance = abs($deltaPercent) <= 5.0;

        $statusLabel = $isInTolerance
            ? 'Tổng lưu lượng đang nằm trong khoảng dự tính ±5%'
            : 'Tổng lưu lượng chênh lệch ' . ($deltaPercent > 0 ? "+{$deltaPercent}%" : "{$deltaPercent}%") . ' so với nhu cầu (Bạn có thể điều chỉnh thêm số lượng)';
        $statusClass = $isInTolerance ? 'success' : 'warning';

        return [
            'items' => $items,
            'total_actual_airflow' => $totalFlow,
            'delta_flow' => $deltaFlow,
            'delta_percent' => $deltaPercent,
            'is_in_tolerance' => $isInTolerance,
            'total_price' => $totalPrice,
            'status_label' => $statusLabel,
            'status_class' => $statusClass,
        ];
    }

    /**
     * Compute Cooling Pad requirements based on actual fan airflow
     */
    public function computeCoolingPads(float $actualFanAirflow, ?array $selectedPads = null): array
    {
        $requiredPadArea = ($actualFanAirflow > 0)
            ? round($actualFanAirflow / self::COOLING_PAD_VELOCITY, 2)
            : 0.0;

        $padCatalog = collect(self::STANDARD_COOLING_PADS)->map(function ($pad) use ($requiredPadArea) {
            $area = round($pad['length'] * $pad['width'], 2);
            $recommendedQty = ($area > 0 && $requiredPadArea > 0)
                ? (int) ceil($requiredPadArea / $area)
                : 1;

            $suppliedArea = round($recommendedQty * $area, 2);

            return array_merge($pad, [
                'area_per_unit' => $area,
                'recommended_qty' => $recommendedQty,
                'supplied_area' => $suppliedArea,
                'dimension_text' => (int)($pad['length']*1000) . 'x' . (int)($pad['width']*1000) . 'x' . $pad['thickness'] . 'mm',
                'is_sufficient' => $suppliedArea >= $requiredPadArea,
            ]);
        });

        // If user explicitly picked cooling pads
        $chosenPads = [];
        $totalPadPrice = 0;
        $totalSuppliedPadArea = 0;

        if (!empty($selectedPads)) {
            foreach ($selectedPads as $p) {
                $sku = $p['sku'] ?? '';
                $catalogItem = $padCatalog->firstWhere('sku', $sku);
                $qty = max(1, (int) ($p['quantity'] ?? ($catalogItem['recommended_qty'] ?? 1)));
                $unitPrice = (float) ($p['unit_price'] ?? ($catalogItem['unit_price'] ?? 0));
                $areaUnit = (float) ($catalogItem['area_per_unit'] ?? 1.08);

                $chosenPads[] = [
                    'sku' => $sku,
                    'name' => $p['name'] ?? ($catalogItem['name'] ?? 'Tấm làm mát Cooling Pad'),
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'total_price' => $qty * $unitPrice,
                    'area_per_unit' => $areaUnit,
                    'total_area' => round($qty * $areaUnit, 2),
                    'dimensions' => $catalogItem['dimension_text'] ?? '1800x600x150mm',
                ];

                $totalPadPrice += $qty * $unitPrice;
                $totalSuppliedPadArea += round($qty * $areaUnit, 2);
            }
        }

        return [
            'cooling_velocity' => self::COOLING_PAD_VELOCITY,
            'actual_fan_airflow' => $actualFanAirflow,
            'required_pad_area' => $requiredPadArea,
            'pad_options' => $padCatalog->toArray(),
            'chosen_pads' => $chosenPads,
            'total_pad_price' => $totalPadPrice,
            'total_supplied_pad_area' => $totalSuppliedPadArea,
        ];
    }

    /**
     * Query candidate fans based on active tab, required airflow, voltage and filters.
     * Returns ranked collection capped at max 6 results according to Docx spec.
     */
    public function queryCandidateFans(string $tab, float $requiredAirflow, array $filters = [], string $locale = 'vi'): Collection
    {
        $query = Product::query()
            ->with(['brand', 'category'])
            ->where('is_active', true)
            ->whereNotNull('airflow')
            ->where('airflow', '>', 0);

        // Tab constraints
        if ($tab === 'cooling-pad') {
            $query->where('use_cooling_pad', true);
        } elseif ($tab === 'thong-gio-phong') {
            $query->whereIn('fan_type', ['Quạt gắn tường', 'Quạt nối ống âm trần', 'Quạt thông gió vuông']);
        } else {
            $query->where('use_ventilation', true);
        }

        // Voltage filter if set
        $voltage = $filters['voltage'] ?? null;
        if (!empty($voltage) && in_array($voltage, ['220V', '380V'], true)) {
            $query->where('voltage', 'like', "%{$voltage}%");
        }

        // 1. Brand filter
        if (!empty($filters['brand'])) {
            $query->whereHas('brand', function ($b) use ($filters) {
                $b->where('slug', $filters['brand'])
                  ->orWhere('name', $filters['brand']);
            });
        }

        // 2. Fan Type filter
        if (!empty($filters['fan_type'])) {
            $query->where('fan_type', $filters['fan_type']);
        }

        // 3. Size / Hole Size filter
        if (!empty($filters['size'])) {
            $sizeVal = $filters['size'];
            $query->where(function ($q) use ($sizeVal) {
                $q->where('hole_size', 'like', "%{$sizeVal}%")
                  ->orWhere('size_display', 'like', "%{$sizeVal}%");
            });
        }

        // 4. Price range filter
        if (!empty($filters['price_range'])) {
            match ($filters['price_range']) {
                'under_2m' => $query->where('price', '<', 2000000),
                '2m_to_5m' => $query->whereBetween('price', [2000000, 5000000]),
                'over_5m' => $query->where('price', '>', 5000000),
                default => null,
            };
        }

        $candidates = $query->get();

        // Score candidates based on suitability
        $scored = $candidates->map(function (Product $fan) use ($requiredAirflow, $locale) {
            $airflow = (float) $fan->airflow;
            $unitPrice = (float) $fan->price;

            if ($requiredAirflow > 0 && $airflow > 0) {
                $qty = (int) ceil($requiredAirflow / $airflow);
                $totalAirflow = $qty * $airflow;
                $deltaAirflow = $totalAirflow - $requiredAirflow;
                $deltaRatio = abs($deltaAirflow) / $requiredAirflow;

                // Penalize extreme fan counts: e.g. using 100 tiny fans for huge warehouse
                $quantityPenalty = 0.0;
                if ($qty > 30) {
                    $quantityPenalty = 5.0 + ($qty / 10.0);
                } elseif ($qty > 15) {
                    $quantityPenalty = 2.0;
                }

                $score = $deltaRatio + $quantityPenalty;
            } else {
                $qty = 1;
                $totalAirflow = $airflow;
                $deltaAirflow = 0;
                $deltaRatio = 0.0;
                $score = 1.0;
            }

            return [
                'id' => $fan->id,
                'sku' => $fan->sku,
                'name' => $fan->getTranslation('name', $locale) ?: $fan->sku,
                'slug' => $fan->slug,
                'detail_url' => route('client.products.detail', ['locale' => $locale, 'slug' => $fan->slug]),
                'image_url' => $fan->image_url ?: '/client-assets/images/km-vuong-1380.jpg',
                'brand_name' => $fan->brand?->name ?? 'Winline',
                'fan_type' => $fan->fan_type ?: 'Quạt thông gió',
                'size_display' => $fan->size_display ?: ($fan->hole_size ?: '-'),
                'hole_size' => $fan->hole_size ?: ($fan->size_display ?: '-'),
                'power' => $fan->power ?: '-',
                'voltage' => $fan->voltage ?: '220V',
                'airflow' => $airflow,
                'formatted_airflow' => number_format($airflow, 0, ',', '.') . ' m³/h',
                'estimated_qty' => max(1, $qty),
                'total_airflow' => $totalAirflow,
                'formatted_total_airflow' => number_format($totalAirflow, 0, ',', '.') . ' m³/h',
                'unit_price' => $unitPrice,
                'formatted_price' => number_format($unitPrice, 0, ',', '.') . ' đ',
                'score' => $score,
            ];
        });

        // Sort by score ascending (lowest delta and most reasonable quantity first)
        $sorted = $scored->sortBy('score')->values();

        // Docx requirement: maximum 6 products displayed
        return $sorted->take(6);
    }

    /**
     * Get distinct filter options for a tab
     */
    public function getFilterOptions(string $tab): array
    {
        $query = Product::query()
            ->with('brand')
            ->where('is_active', true)
            ->whereNotNull('airflow');

        if ($tab === 'cooling-pad') {
            $query->where('use_cooling_pad', true);
        } elseif ($tab === 'thong-gio-phong') {
            $query->whereIn('fan_type', ['Quạt gắn tường', 'Quạt nối ống âm trần', 'Quạt thông gió vuông']);
        } else {
            $query->where('use_ventilation', true);
        }

        $products = $query->get();

        $brands = $products->pluck('brand')->filter()->unique('id')->values()->map(fn ($b) => [
            'slug' => $b->slug,
            'name' => $b->name,
        ])->toArray();

        $fanTypes = $products->pluck('fan_type')->filter()->unique()->values()->toArray();

        $sizes = $products->map(function ($p) use ($tab) {
            return ($tab === 'thong-gio-phong') ? $p->hole_size : ($p->size_display ?: $p->hole_size);
        })->filter()->unique()->values()->toArray();

        return [
            'brands' => $brands,
            'fan_types' => $fanTypes,
            'sizes' => $sizes,
            'price_ranges' => [
                ['value' => 'all', 'label' => 'Tất cả mức giá'],
                ['value' => 'under_2m', 'label' => 'Dưới 2.000.000 đ'],
                ['value' => '2m_to_5m', 'label' => '2.000.000 - 5.000.000 đ'],
                ['value' => 'over_5m', 'label' => 'Trên 5.000.000 đ'],
            ],
        ];
    }
}
