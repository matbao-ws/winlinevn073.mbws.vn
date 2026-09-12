@php
    $columns = old('columns', $table->columns ?? []);
    if (!is_array($columns) || empty($columns)) {
        $columns = [
            'Điện áp (V/Hz)',
            'Công suất (W)',
            'Lưu lượng gió (m³/h)',
            'Vận tốc gió (m/s)',
            'Độ ồn (dB)',
            'Số Động cơ (Cái)',
            'Kích thước quạt (mm)',
            'Cân nặng (kg - net)',
        ];
    }
    $itemsList = old('items');
    if ($itemsList === null) {
        $itemsList = $items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'model_name' => $item->model_name,
                'product_name' => $item->product?->name,
                'product_sku' => $item->product?->sku,
                'product_price' => $item->product?->price,
                'custom_price' => $item->custom_price,
                'custom_url' => $item->custom_url,
                'specs' => $item->specs ?? [],
            ];
        })->toArray();
    }
@endphp

<div class="row">
    {{-- Cột trái: Thông tin bảng & Danh sách dòng model --}}
    <div class="col-lg-8">
        {{-- Card 1: Thông tin chung & Cột thông số --}}
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold text-dark mb-3">1. Thông tin chung & Cột thông số</h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="name">Tên quản trị (Nội bộ) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                               value="{{ old('name', $table->name) }}" placeholder="VD: Bảng quạt cắt gió Nanyoo-Z (cửa < 5.5m)" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="title">Tiêu đề hiển thị (Storefront) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" 
                               value="{{ old('title', $table->title) }}" placeholder="VD: Quạt cắt gió Nanyoo-Z Được đề xuất cho cửa cao dưới 5.5m" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="subtitle">Ghi chú phụ / Mô tả ngắn (Tùy chọn)</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle" 
                               value="{{ old('subtitle', $table->subtitle) }}" placeholder="VD: Bảng thông số chi tiết và giá tham khảo cho các kích cỡ chiều dài">
                    </div>
                </div>

                {{-- Cấu hình Cột thông số động --}}
                <div class="border rounded p-3 bg-light-subtle mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                        <div>
                            <label class="form-label fw-bold mb-0 text-dark">Danh sách Cột thông số kỹ thuật</label>
                            <div class="fs-2 text-muted">Các cột hiển thị giữa cột "Model" và "Giá bán"</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-column">
                            <i class="ti ti-plus me-1"></i> Thêm cột mới
                        </button>
                    </div>

                    <div id="columns-container" class="d-flex flex-wrap gap-2 mb-3">
                        @foreach($columns as $index => $col)
                            <div class="input-group input-group-sm column-tag-item" style="width: auto; max-width: 220px;" data-index="{{ $index }}">
                                <span class="input-group-text bg-white"><i class="ti ti-columns fs-3 text-muted"></i></span>
                                <input type="text" name="columns[]" class="form-control form-control-sm column-name-input" value="{{ $col }}" required>
                                <button type="button" class="btn btn-outline-danger btn-remove-column" title="Xóa cột này"><i class="ti ti-x"></i></button>
                            </div>
                        @endforeach
                    </div>

                    {{-- Gợi ý cột phổ biến --}}
                    <div class="fs-2 text-muted mt-2">
                        <span class="fw-semibold">Gợi ý thêm nhanh:</span>
                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill me-1 mb-1 js-quick-col" data-col="Điện áp (V/Hz)">+ Điện áp</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill me-1 mb-1 js-quick-col" data-col="Công suất (W)">+ Công suất</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill me-1 mb-1 js-quick-col" data-col="Lưu lượng gió (m³/h)">+ Lưu lượng</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill me-1 mb-1 js-quick-col" data-col="Vận tốc gió (m/s)">+ Vận tốc gió</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill me-1 mb-1 js-quick-col" data-col="Độ ồn (dB)">+ Độ ồn</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill me-1 mb-1 js-quick-col" data-col="Số Động cơ (Cái)">+ Số động cơ</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill me-1 mb-1 js-quick-col" data-col="Kích thước quạt (mm)">+ Kích thước</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill me-1 mb-1 js-quick-col" data-col="Cân nặng (kg - net)">+ Cân nặng</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Danh sách các Model / Dòng dữ liệu --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-0">2. Danh sách Model & Thông số tương ứng</h5>
                        <div class="fs-2 text-muted">Chọn sản phẩm thực tế trong kho để tự động đồng bộ link & giá bán real-time</div>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" id="btn-add-row">
                        <i class="ti ti-plus me-1"></i> Thêm model
                    </button>
                </div>

                <div id="items-rows-container">
                    {{-- Các dòng model sẽ được render ở đây qua JavaScript / PHP --}}
                </div>

                <div class="text-center py-3">
                    <button type="button" class="btn btn-outline-primary btn-sm px-4" id="btn-add-row-bottom">
                        <i class="ti ti-plus me-1"></i> Thêm model tiếp theo
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Cột phải: Cài đặt hiển thị & Lưu --}}
    <div class="col-lg-4">
        {{-- Card lưu & trạng thái --}}
        <div class="card mb-4 shadow-sm border-0 sticky-top" style="top: 80px;">
            <div class="card-body">
                <h5 class="card-title fw-bold text-dark mb-3">Tùy chọn hiển thị</h5>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', $table->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_active">Kích hoạt hiển thị</label>
                    <div class="fs-2 text-muted">Nếu tắt, bảng sẽ tạm ẩn ngoài storefront.</div>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="show_price" name="show_price" value="1" 
                           {{ old('show_price', $table->show_price ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="show_price">Hiển thị Cột Giá bán Real-time</label>
                    <div class="fs-2 text-muted">Tự động lấy giá sản phẩm mới nhất trong database.</div>
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch" id="show_action_btn" name="show_action_btn" value="1" 
                           {{ old('show_action_btn', $table->show_action_btn ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="show_action_btn">Hiển thị Nút Xem chi tiết</label>
                    <div class="fs-2 text-muted">Nút thao tác chuyển nhanh đến trang sản phẩm.</div>
                </div>

                <hr class="my-3">

                @if($table->exists)
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs-2 mb-1">MÃ NHÚNG BẢNG (SHORTCODE):</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm bg-light fw-bold text-primary" 
                                   id="shortcode-input" value="[bang_so_sanh id=&quot;{{ $table->id }}&quot;]" readonly>
                            <button class="btn btn-primary btn-sm copy-shortcode-btn" type="button" data-target="shortcode-input">
                                <i class="ti ti-copy"></i>
                            </button>
                        </div>
                        <div class="fs-2 text-muted mt-1">Dán mã này vào bất kỳ bài viết tin tức hoặc mô tả sản phẩm.</div>
                    </div>
                @endif

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2 fw-bold">
                        <i class="ti ti-device-floppy me-1"></i> Lưu bảng so sánh model
                    </button>
                    <a href="{{ route('admin.model-tables.index') }}" class="btn btn-outline-secondary">
                        Hủy bỏ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    // 1. Initial State Data
    const searchUrl = "{{ route('admin.model-tables.search-products') }}";
    let initialItems = @json($itemsList);

    const columnsContainer = document.getElementById('columns-container');
    const itemsContainer = document.getElementById('items-rows-container');
    const btnAddColumn = document.getElementById('btn-add-column');
    const btnAddRow = document.getElementById('btn-add-row');
    const btnAddRowBottom = document.getElementById('btn-add-row-bottom');

    // Helper: Get Current Column Names
    function getColumns() {
        const cols = [];
        document.querySelectorAll('.column-name-input').forEach(input => {
            const val = input.value.trim();
            if (val) cols.push(val);
        });
        return cols;
    }

    // Add Column
    function addColumn(name = '') {
        const index = document.querySelectorAll('.column-tag-item').length;
        const div = document.createElement('div');
        div.className = 'input-group input-group-sm column-tag-item';
        div.style.width = 'auto';
        div.style.maxWidth = '220px';
        div.setAttribute('data-index', index);
        div.innerHTML = `
            <span class="input-group-text bg-white"><i class="ti ti-columns fs-3 text-muted"></i></span>
            <input type="text" name="columns[]" class="form-control form-control-sm column-name-input" value="${escapeHtml(name)}" required placeholder="Tên cột...">
            <button type="button" class="btn btn-outline-danger btn-remove-column" title="Xóa cột này"><i class="ti ti-x"></i></button>
        `;
        columnsContainer.appendChild(div);
        bindColumnEvents(div);
        refreshRowSpecInputs();
    }

    function bindColumnEvents(element) {
        element.querySelector('.btn-remove-column')?.addEventListener('click', function() {
            element.remove();
            refreshRowSpecInputs();
        });
        element.querySelector('.column-name-input')?.addEventListener('input', function() {
            refreshRowSpecInputs();
        });
    }

    document.querySelectorAll('.column-tag-item').forEach(bindColumnEvents);

    btnAddColumn?.addEventListener('click', () => addColumn(''));

    document.querySelectorAll('.js-quick-col').forEach(btn => {
        btn.addEventListener('click', function() {
            const col = this.getAttribute('data-col');
            const existing = getColumns();
            if (!existing.includes(col)) {
                addColumn(col);
            }
        });
    });

    // 2. Add / Render Rows
    let rowIndex = 0;

    function addRow(data = {}) {
        const currentCols = getColumns();
        const rowId = `row_${rowIndex++}`;
        const card = document.createElement('div');
        card.className = 'card border mb-3 model-row-card shadow-none';
        card.id = rowId;

        const specs = data.specs || {};
        const productId = data.product_id || '';
        const productName = data.product_name || '';
        const productSku = data.product_sku || '';
        const productPrice = data.product_price ? new Intl.NumberFormat('vi-VN').format(data.product_price) + ' đ' : '';
        const modelName = data.model_name || productSku || '';

        card.innerHTML = `
            <div class="card-header bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark fs-3 row-number-badge">Model #${itemsContainer.children.length + 1}</span>
                <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-remove-row" title="Xóa dòng này">
                    <i class="ti ti-trash"></i> Xóa
                </button>
            </div>
            <div class="card-body p-3">
                <div class="row g-2 mb-3 align-items-end">
                    <div class="col-md-5 position-relative">
                        <label class="form-label fs-2 fw-semibold mb-1">Chọn sản phẩm liên kết (Tự lấy Giá & Link)</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                            <input type="text" class="form-control js-product-search-input" 
                                   placeholder="Gõ tìm tên hoặc SKU..." 
                                   value="${escapeHtml(productName ? (productName + (productSku ? ' (' + productSku + ')' : '')) : '')}">
                            <button type="button" class="btn btn-outline-secondary js-btn-clear-product" title="Bỏ liên kết">×</button>
                        </div>
                        <input type="hidden" name="items[${rowId}][product_id]" class="js-product-id-val" value="${productId}">
                        <div class="product-search-dropdown list-group shadow position-absolute w-100 mt-1 d-none" style="z-index: 1050; max-height: 220px; overflow-y: auto;"></div>
                        <div class="js-product-info-pill mt-1 ${productId ? '' : 'd-none'}">
                            <span class="badge bg-light-success text-success fw-semibold fs-2">
                                <i class="ti ti-check me-1"></i> Giá real-time: <strong class="js-price-preview">${productPrice || 'Đã liên kết'}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fs-2 fw-semibold mb-1">Tên Model hiển thị trên bảng <span class="text-danger">*</span></label>
                        <input type="text" name="items[${rowId}][model_name]" class="form-control form-control-sm js-model-name-input fw-bold" 
                               value="${escapeHtml(modelName)}" placeholder="VD: FM-5509Z-L/Y" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fs-2 fw-semibold mb-1">Giá nhập tay (khi không chọn SP)</label>
                        <input type="number" step="1000" name="items[${rowId}][custom_price]" class="form-control form-control-sm" 
                               value="${data.custom_price || ''}" placeholder="Giá VNĐ...">
                    </div>
                </div>

                {{-- Thông số các cột --}}
                <div class="row g-2 pt-2 border-top js-specs-container">
                    ${renderSpecFields(rowId, currentCols, specs)}
                </div>
            </div>
        `;

        itemsContainer.appendChild(card);
        bindRowEvents(card);
        updateRowNumbers();
    }

    function renderSpecFields(rowId, cols, specs) {
        if (cols.length === 0) {
            return `<div class="col-12 text-muted fs-2 fst-italic">Chưa có cột thông số nào được định nghĩa ở trên.</div>`;
        }
        return cols.map(col => {
            const val = specs[col] !== undefined ? specs[col] : '';
            return `
                <div class="col-md-3 col-6 js-spec-field" data-col-name="${escapeHtml(col)}">
                    <label class="form-label fs-2 text-muted text-truncate w-100 mb-0" title="${escapeHtml(col)}">${escapeHtml(col)}</label>
                    <input type="text" name="items[${rowId}][specs][${escapeHtml(col)}]" 
                           class="form-control form-control-sm" value="${escapeHtml(val)}" placeholder="—">
                </div>
            `;
        }).join('');
    }

    function refreshRowSpecInputs() {
        const currentCols = getColumns();
        document.querySelectorAll('.model-row-card').forEach(card => {
            const rowId = card.id;
            const container = card.querySelector('.js-specs-container');
            if (!container) return;

            // Preserve current values
            const existingSpecs = {};
            container.querySelectorAll('input').forEach(input => {
                const nameMatch = input.name.match(/\[specs\]\[(.*?)\]/);
                if (nameMatch) {
                    existingSpecs[nameMatch[1]] = input.value;
                }
            });

            container.innerHTML = renderSpecFields(rowId, currentCols, existingSpecs);
        });
    }

    function updateRowNumbers() {
        document.querySelectorAll('.model-row-card').forEach((card, idx) => {
            const badge = card.querySelector('.row-number-badge');
            if (badge) badge.textContent = `Model #${idx + 1}`;
        });
    }

    function bindRowEvents(card) {
        // Remove Row
        card.querySelector('.btn-remove-row')?.addEventListener('click', function() {
            card.remove();
            updateRowNumbers();
        });

        // Search Product Autocomplete
        const searchInput = card.querySelector('.js-product-search-input');
        const productIdInput = card.querySelector('.js-product-id-val');
        const modelNameInput = card.querySelector('.js-model-name-input');
        const dropdown = card.querySelector('.product-search-dropdown');
        const infoPill = card.querySelector('.js-product-info-pill');
        const pricePreview = card.querySelector('.js-price-preview');
        const clearBtn = card.querySelector('.js-btn-clear-product');

        let debounceTimer = null;

        searchInput?.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const query = this.value.trim();
            if (query.length < 1) {
                dropdown.classList.add('d-none');
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch(`${searchUrl}?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        dropdown.innerHTML = '';
                        if (!data.results || data.results.length === 0) {
                            dropdown.innerHTML = `<div class="p-2 text-muted fs-2">Không tìm thấy sản phẩm nào.</div>`;
                            dropdown.classList.remove('d-none');
                            return;
                        }

                        data.results.forEach(prod => {
                            const item = document.createElement('a');
                            item.href = 'javascript:void(0)';
                            item.className = 'list-group-item list-group-item-action d-flex align-items-center gap-2 py-2';
                            item.innerHTML = `
                                <img src="${prod.image_url}" style="width: 32px; height: 32px; object-fit: cover; border-radius: 4px;">
                                <div class="flex-grow-1 text-truncate">
                                    <div class="fw-bold fs-2 text-dark text-truncate">${escapeHtml(prod.name)}</div>
                                    <div class="fs-1 text-muted">SKU: ${escapeHtml(prod.sku)} | Giá: <span class="text-danger fw-bold">${prod.price_formatted}</span></div>
                                </div>
                            `;
                            item.addEventListener('click', () => {
                                productIdInput.value = prod.id;
                                searchInput.value = prod.name + (prod.sku ? ' (' + prod.sku + ')' : '');
                                if (!modelNameInput.value || modelNameInput.value === '') {
                                    modelNameInput.value = prod.sku || prod.name;
                                }
                                pricePreview.textContent = prod.price_formatted;
                                infoPill.classList.remove('d-none');
                                dropdown.classList.add('d-none');
                            });
                            dropdown.appendChild(item);
                        });
                        dropdown.classList.remove('d-none');
                    });
            }, 250);
        });

        clearBtn?.addEventListener('click', function() {
            productIdInput.value = '';
            searchInput.value = '';
            infoPill.classList.add('d-none');
            dropdown.classList.add('d-none');
        });

        // Close dropdown when clicked outside
        document.addEventListener('click', function(e) {
            if (!card.contains(e.target)) {
                dropdown?.classList.add('d-none');
            }
        });
    }

    // Add Row Buttons
    btnAddRow?.addEventListener('click', () => addRow({}));
    btnAddRowBottom?.addEventListener('click', () => addRow({}));

    // Populate Initial Items or create at least one empty row
    if (initialItems && initialItems.length > 0) {
        initialItems.forEach(item => addRow(item));
    } else {
        addRow({});
    }

    // Copy Shortcode Button
    document.querySelectorAll('.copy-shortcode-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = document.getElementById(this.getAttribute('data-target'));
            if (input) {
                input.select();
                navigator.clipboard.writeText(input.value);
                const icon = this.querySelector('i');
                if (icon) {
                    icon.className = 'ti ti-check text-white';
                    setTimeout(() => icon.className = 'ti ti-copy', 1500);
                }
            }
        });
    });

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
})();
</script>
@endpush
