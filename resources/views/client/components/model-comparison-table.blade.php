@props([
    'table',
    'currentProductId' => null,
    'locale' => null,
])

@php
    $locale = $locale ?: app()->getLocale();
    $columns = is_array($table->columns) ? $table->columns : [];
    $items = $table->relationLoaded('items') 
        ? $table->items 
        : $table->items()->with(['product.localizedSlugs'])->get();
@endphp

<div class="model-matrix-wrapper" id="matrix-table-{{ $table->id }}" style="margin: 24px 0 28px; clear: both;">
    <div class="model-matrix-card" style="background: #ffffff; border: 1px solid #d9e2ec; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 16px rgba(0, 53, 79, 0.06);">
        {{-- Tiêu đề Bảng theo đúng mẫu Winline --}}
        <div class="model-matrix-header" style="padding: 14px 18px; border-bottom: 2px solid #0070ba; background: #f8fafc; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
            <div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 800; color: #00354f; letter-spacing: -0.01em; display: flex; align-items: center; gap: 8px;">
                    <span style="display: inline-block; width: 4px; height: 16px; background: #0070ba; border-radius: 2px;"></span>
                    {{ $table->title ?: $table->name }}
                </h4>
                @if($table->subtitle)
                    <p style="margin: 4px 0 0; font-size: 13px; color: #64748b;">{{ $table->subtitle }}</p>
                @endif
            </div>
            <div class="matrix-hint-pill" style="font-size: 11.5px; color: #0284c7; background: #e0f2fe; padding: 4px 10px; border-radius: 20px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                <i class="fas fa-arrows-alt-h" style="font-size: 11px;"></i> Click model để xem chi tiết & đặt hàng
            </div>
        </div>

        {{-- Bảng thông số kỹ thuật cuộn ngang mượt mà --}}
        <div class="matrix-table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%;">
            <table class="model-matrix-table" style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 720px;">
                <thead>
                    <tr style="background: #0070ba; color: #ffffff; text-align: center;">
                        <th style="padding: 10px 8px; border: 1px solid #0284c7; width: 44px; font-weight: 700; white-space: nowrap;">No.</th>
                        <th style="padding: 10px 14px; border: 1px solid #0284c7; font-weight: 700; text-align: left; min-width: 130px; white-space: nowrap;">Model</th>
                        @foreach($columns as $col)
                            <th style="padding: 10px 10px; border: 1px solid #0284c7; font-weight: 700; white-space: nowrap;">{{ $col }}</th>
                        @endforeach
                        @if($table->show_price)
                            <th style="padding: 10px 12px; border: 1px solid #0284c7; font-weight: 700; min-width: 110px; white-space: nowrap; text-align: right;">Giá bán</th>
                        @endif
                        @if($table->show_action_btn)
                            <th style="padding: 10px 10px; border: 1px solid #0284c7; width: 85px; font-weight: 700; white-space: nowrap;">Thao tác</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $index => $item)
                        @php
                            $isCurrent = $currentProductId && (int)$item->product_id === (int)$currentProductId;
                            $rowUrl = $item->getUrl($locale);
                            $formattedPrice = $item->getFormattedPrice();
                            $comparePrice = $item->getFormattedComparePrice();
                        @endphp
                        <tr class="matrix-row {{ $isCurrent ? 'is-current-model' : '' }}" 
                            style="border-bottom: 1px solid #e2e8f0; {{ $isCurrent ? 'background-color: #f0f9ff !important; font-weight: 600;' : ($index % 2 === 1 ? 'background-color: #f8fafc;' : 'background-color: #ffffff;') }} transition: background-color 0.15s ease;">
                            
                            {{-- Cột STT --}}
                            <td style="padding: 9px 8px; text-align: center; color: #64748b; font-weight: 600; border: 1px solid #e2e8f0;">
                                {{ $index + 1 }}
                            </td>

                            {{-- Cột Model (Clickable) --}}
                            <td style="padding: 9px 14px; text-align: left; border: 1px solid #e2e8f0; white-space: nowrap;">
                                @if($rowUrl && $rowUrl !== '#')
                                    <a href="{{ $rowUrl }}" 
                                       title="Xem chi tiết {{ $item->model_name }}"
                                       class="matrix-model-link"
                                       style="color: #00354f; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                        {{ $item->model_name }}
                                        <i class="fas fa-external-link-alt" style="font-size: 10px; opacity: 0.5;"></i>
                                    </a>
                                @else
                                    <span style="color: #00354f; font-weight: 700;">{{ $item->model_name }}</span>
                                @endif

                                @if($isCurrent)
                                    <span style="background: #0284c7; color: #ffffff; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 4px; margin-left: 6px; display: inline-block;">Đang xem</span>
                                @endif
                            </td>

                            {{-- Các cột thông số kỹ thuật --}}
                            @foreach($columns as $col)
                                <td style="padding: 9px 10px; text-align: center; color: #334155; border: 1px solid #e2e8f0; white-space: nowrap;">
                                    {{ $item->getSpecValue($col) }}
                                </td>
                            @endforeach

                            {{-- Cột Giá Real-time --}}
                            @if($table->show_price)
                                <td style="padding: 9px 12px; text-align: right; border: 1px solid #e2e8f0; white-space: nowrap;">
                                    @if($comparePrice)
                                        <del style="font-size: 11px; color: #94a3b8; font-weight: 400; display: block; line-height: 1;">{{ $comparePrice }}</del>
                                    @endif
                                    <span style="font-family: 'IBM Plex Mono', monospace, sans-serif; font-size: 13.5px; font-weight: 800; color: #d41e3d;">
                                        {{ $formattedPrice }}
                                    </span>
                                </td>
                            @endif

                            {{-- Cột Thao tác --}}
                            @if($table->show_action_btn)
                                <td style="padding: 7px 10px; text-align: center; border: 1px solid #e2e8f0; white-space: nowrap;">
                                    @if($rowUrl && $rowUrl !== '#')
                                        <a href="{{ $rowUrl }}" 
                                           class="btn-matrix-view"
                                           style="display: inline-block; background: {{ $isCurrent ? '#64748b' : '#00354f' }}; color: #ffffff; font-size: 11.5px; font-weight: 600; padding: 4px 10px; border-radius: 4px; text-decoration: none; transition: background 0.2s ease;">
                                            {{ $isCurrent ? 'Hiện tại' : 'Xem' }}
                                        </a>
                                    @else
                                        <span style="font-size: 11px; color: #94a3b8;">—</span>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 2 + ($table->show_price ? 1 : 0) + ($table->show_action_btn ? 1 : 0) }}" 
                                style="padding: 18px; text-align: center; color: #94a3b8; font-style: italic;">
                                Chưa có model nào trong bảng này.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer hướng dẫn trên mobile --}}
        <div class="matrix-mobile-footer" style="padding: 6px 14px; background: #f8fafc; border-top: 1px solid #e2e8f0; font-size: 11px; color: #94a3b8; display: flex; justify-content: space-between; align-items: center;">
            <span>* Thông số và giá bán được cập nhật tự động từ Winline.vn</span>
            <span class="d-md-none"><i class="fas fa-arrows-alt-h"></i> Cuộn ngang để xem đủ</span>
        </div>
    </div>
</div>

<style>
.matrix-row:hover {
    background-color: #f0f7ff !important;
}
.matrix-model-link:hover {
    color: #ea580c !important;
    text-decoration: underline !important;
}
.btn-matrix-view:hover {
    background: #0070ba !important;
}
.matrix-row.is-current-model {
    border-left: 3px solid #0070ba;
}
@media (max-width: 768px) {
    .model-matrix-header {
        flex-direction: column;
        align-items: flex-start !important;
    }
    .matrix-hint-pill {
        width: 100%;
        justify-content: center;
    }
}
</style>
