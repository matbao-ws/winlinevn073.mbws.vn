@extends("client.layouts.app")

@section("title", ($currentCategory ? $currentCategory->getTranslation("name", app()->getLocale()) : ($currentBrand ? "Quạt " . $currentBrand->getTranslation("name", app()->getLocale()) : "Danh mục sản phẩm")) . " | Winline.vn")

@section("content")
<div class="product-listing-page">
  {{-- Breadcrumb --}}
  <div class="breadcrumb">
    <a href="{{ route("client.home") }}">Trang chủ</a> › 
    @if($currentCategory && $currentCategory->parent)
      <a href="{{ route("client.products", ["category" => $currentCategory->parent->slug]) }}">{{ $currentCategory->parent->getTranslation("name", app()->getLocale()) }}</a> › 
    @endif
    @if($currentCategory)
      <span class="current">{{ $currentCategory->getTranslation("name", app()->getLocale()) }}</span>
    @elseif($currentBrand)
      <span class="current">{{ $currentBrand->getTranslation("name", app()->getLocale()) }}</span>
    @else
      <span class="current">Tất cả sản phẩm</span>
    @endif
  </div>

  {{-- Page Head --}}
  <div class="page-head">
    <div class="ph-left">
      <h1>
        @if($currentCategory)
          {{ $currentCategory->getTranslation("name", app()->getLocale()) }}
        @elseif($currentBrand)
          Quạt {{ $currentBrand->getTranslation("name", app()->getLocale()) }} chính hãng
        @else
          Tất cả sản phẩm quạt &amp; làm mát Winline
        @endif
      </h1>
      <div class="count">
        <strong>{{ $products->total() }}</strong> sản phẩm chính hãng — Đầy đủ CO/CQ, cam kết 100% dây đồng &amp; chiết khấu dự án tốt nhất
      </div>
    </div>
  </div>

  {{-- 1. DẢI LOGO THƯƠNG HIỆU CẤP 3 (Điện Máy Xanh Style) --}}
  @if(isset($categoryBrands) && $categoryBrands->isNotEmpty())
    @php
      $selectedBrands = (array) ($filters["brand"] ?? []);
      if (is_string($filters["brand"] ?? null)) {
        $selectedBrands = array_filter(explode(",", $filters["brand"]));
      }
    @endphp
    <div class="brand-quick-bar">
      <div class="brand-quick-label">Thương hiệu:</div>
      <div class="brand-quick-scroll">
        <a href="{{ route("client.products", array_merge($filters, ["brand" => null])) }}" class="brand-quick-pill {{ empty($selectedBrands) ? "active" : "" }}">
          <span>Tất cả</span>
        </a>
        @foreach($categoryBrands as $b)
          @php
            $isActive = in_array($b->slug, $selectedBrands);
            $newBrands = $isActive ? array_diff($selectedBrands, [$b->slug]) : [$b->slug];
            $brandParam = !empty($newBrands) ? implode(",", $newBrands) : null;
          @endphp
          <a href="{{ route("client.products", array_merge($filters, ["brand" => $brandParam])) }}" class="brand-quick-pill {{ $isActive ? "active" : "" }}" title="{{ $b->getTranslation("name", app()->getLocale()) }}">
            @if($b->image_url)
              <img src="{{ asset($b->image_url) }}" alt="{{ $b->getTranslation("name", app()->getLocale()) }}" class="brand-pill-logo">
            @else
              <span class="brand-pill-name">{{ $b->getTranslation("name", app()->getLocale()) }}</span>
            @endif
          </a>
        @endforeach
      </div>
    </div>
  @endif

  {{-- 2. BỘ LỌC HÀNG NGANG (Thay thế Sidebar trái, chuẩn dienmayxanh.com) --}}
  <form id="filterForm" action="{{ route("client.products") }}" method="GET" class="horizontal-filters-wrap">
    @if(!empty($filters["category"]))
      <input type="hidden" name="category" value="{{ $filters["category"] }}">
    @endif
    @if(!empty($filters["q"]))
      <input type="hidden" name="q" value="{{ $filters["q"] }}">
    @endif

    <div class="h-filters-row">
      {{-- Dropdown Thương hiệu --}}
      <div class="h-filter-dropdown" id="hfd-brand">
        <button type="button" class="h-filter-btn {{ !empty($selectedBrands) ? "has-val" : "" }}" onclick="toggleFilterDropdown(\x27hfd-brand\x27)">
          <i class="fas fa-shield-alt"></i> Thương hiệu 
          @if(!empty($selectedBrands))
            <span class="filter-badge">{{ count($selectedBrands) }}</span>
          @endif
          <i class="fas fa-chevron-down arrow"></i>
        </button>
        <div class="h-filter-popover">
          <div class="popover-head">Chọn thương hiệu</div>
          <div class="popover-grid">
            @foreach($brands as $b)
              <label class="popover-check">
                <input type="checkbox" name="brand[]" value="{{ $b->slug }}" {{ in_array($b->slug, $selectedBrands) ? "checked" : "" }} onchange="updateFilterCount()">
                <span>{{ $b->getTranslation("name", app()->getLocale()) }}</span>
                @if($b->products_count)
                  <span class="p-count">({{ $b->products_count }})</span>
                @endif
              </label>
            @endforeach
          </div>
          <div class="popover-actions">
            <button type="button" class="btn-clear-sub" onclick="clearFilterCheckboxes(\x27hfd-brand\x27)">Bỏ chọn</button>
            <button type="submit" class="btn-submit-filter" id="btn-count-brand">Xem kết quả</button>
          </div>
        </div>
      </div>

      {{-- Dropdown Mức giá --}}
      @php
        $minP = $filters["min_price"] ?? "";
        $maxP = $filters["max_price"] ?? "";
        $priceActive = ($minP !== "" || $maxP !== "");
      @endphp
      <div class="h-filter-dropdown" id="hfd-price">
        <button type="button" class="h-filter-btn {{ $priceActive ? "has-val" : "" }}" onclick="toggleFilterDropdown(\x27hfd-price\x27)">
          <i class="fas fa-tags"></i> Mức giá
          <i class="fas fa-chevron-down arrow"></i>
        </button>
        <div class="h-filter-popover">
          <div class="popover-head">Khoảng giá mong muốn</div>
          <div class="popover-radios">
            <label class="popover-radio">
              <input type="radio" name="price_range" value="" {{ !$priceActive ? "checked" : "" }} onchange="setPriceRange(\x27\x27, \x27\x27)">
              <span>Tất cả mức giá</span>
            </label>
            <label class="popover-radio">
              <input type="radio" name="price_range" value="0-1000000" {{ ($minP==0 && $maxP==1000000) ? "checked" : "" }} onchange="setPriceRange(0, 1000000)">
              <span>Dưới 1 triệu</span>
            </label>
            <label class="popover-radio">
              <input type="radio" name="price_range" value="1000000-2000000" {{ ($minP==1000000 && $maxP==2000000) ? "checked" : "" }} onchange="setPriceRange(1000000, 2000000)">
              <span>1 triệu — 2 triệu</span>
            </label>
            <label class="popover-radio">
              <input type="radio" name="price_range" value="2000000-5000000" {{ ($minP==2000000 && $maxP==5000000) ? "checked" : "" }} onchange="setPriceRange(2000000, 5000000)">
              <span>2 triệu — 5 triệu</span>
            </label>
            <label class="popover-radio">
              <input type="radio" name="price_range" value="5000000-999999999" {{ ($minP==5000000) ? "checked" : "" }} onchange="setPriceRange(5000000, \x27\x27)">
              <span>Trên 5 triệu</span>
            </label>
          </div>
          <input type="hidden" name="min_price" id="input_min_price" value="{{ $minP }}">
          <input type="hidden" name="max_price" id="input_max_price" value="{{ $maxP }}">
          <div class="popover-actions">
            <button type="button" class="btn-clear-sub" onclick="setPriceRange(\x27\x27, \x27\x27); document.getElementById(\x27filterForm\x27).submit();">Bỏ chọn</button>
            <button type="submit" class="btn-submit-filter">Xem kết quả</button>
          </div>
        </div>
      </div>

      {{-- Dropdown Sắp xếp --}}
      @php $sortVal = $filters["sort_by"] ?? "latest"; @endphp
      <div class="h-filter-dropdown" id="hfd-sort">
        <button type="button" class="h-filter-btn {{ $sortVal != "latest" ? "has-val" : "" }}" onclick="toggleFilterDropdown(\x27hfd-sort\x27)">
          <i class="fas fa-arrow-down-wide-short"></i> Sắp xếp
          <i class="fas fa-chevron-down arrow"></i>
        </button>
        <div class="h-filter-popover">
          <div class="popover-head">Sắp xếp hiển thị</div>
          <div class="popover-radios">
            <label class="popover-radio">
              <input type="radio" name="sort_by" value="latest" {{ $sortVal=="latest" ? "checked" : "" }} onchange="document.getElementById(\x27filterForm\x27).submit()">
              <span>Mới nhất / Nổi bật</span>
            </label>
            <label class="popover-radio">
              <input type="radio" name="sort_by" value="price_asc" {{ $sortVal=="price_asc" ? "checked" : "" }} onchange="document.getElementById(\x27filterForm\x27).submit()">
              <span>Giá: Thấp đến Cao</span>
            </label>
            <label class="popover-radio">
              <input type="radio" name="sort_by" value="price_desc" {{ $sortVal=="price_desc" ? "checked" : "" }} onchange="document.getElementById(\x27filterForm\x27).submit()">
              <span>Giá: Cao đến Thấp</span>
            </label>
          </div>
        </div>
      </div>

      {{-- Nút Xóa bộ lọc nếu có lọc --}}
      @if(!empty($selectedBrands) || $priceActive || $sortVal != "latest")
        <a href="{{ route("client.products", ["category" => $filters["category"] ?? null]) }}" class="btn-reset-filters" title="Xoá tất cả bộ lọc">
          <i class="fas fa-times-circle"></i> Xóa bộ lọc
        </a>
      @endif
    </div>

    {{-- Active Tags --}}
    @if(!empty($selectedBrands) || $priceActive)
      <div class="active-filter-tags">
        <span class="tag-label">Đang lọc:</span>
        @foreach($selectedBrands as $bSlug)
          @php $bObj = $brands->firstWhere("slug", $bSlug); @endphp
          @if($bObj)
            @php
              $remBrands = array_diff($selectedBrands, [$bSlug]);
              $remParam = !empty($remBrands) ? implode(",", $remBrands) : null;
            @endphp
            <a href="{{ route("client.products", array_merge($filters, ["brand" => $remParam])) }}" class="filter-tag-chip">
              Thương hiệu: {{ $bObj->getTranslation("name", app()->getLocale()) }} <i class="fas fa-times"></i>
            </a>
          @endif
        @endforeach

        @if($priceActive)
          <a href="{{ route("client.products", array_merge($filters, ["min_price" => null, "max_price" => null])) }}" class="filter-tag-chip">
            @if($minP !== "" && $maxP !== "")
              Giá: {{ number_format($minP) }}đ – {{ number_format($maxP) }}đ
            @elseif($minP !== "")
              Giá: Trên {{ number_format($minP) }}đ
            @else
              Giá: Dưới {{ number_format($maxP) }}đ
            @endif
            <i class="fas fa-times"></i>
          </a>
        @endif
      </div>
    @endif
  </form>

  {{-- 3. LƯỚI SẢN PHẨM TOÀN CHIỀU RỘNG (100% Full Width, không còn sidebar) --}}
  <div class="listing-full-container">
    <div class="prod-grid">
      @forelse($products as $product)
        <div class="prod-card">
          <div class="p-img">
            @if($product->is_featured)
              <span class="p-badge">Bán chạy</span>
            @elseif($product->compare_at_price > $product->price)
              <span class="p-badge low">Ưu đãi</span>
            @endif
            <a href="{{ route('client.products.detail', ['slug' => $product->canonicalSlug(app()->getLocale())]) }}" style="display:flex; width:100%; height:100%; align-items:center; justify-content:center;">
              <img src="{{ $product->image_url ? (str_starts_with($product->image_url, 'http') ? $product->image_url : asset($product->image_url)) : asset('client-assets/images/km750s.jpg') }}" alt="{{ $product->getTranslation('name', app()->getLocale()) }}" loading="lazy" onerror="this.src='{{ asset('client-assets/images/km750s.jpg') }}'">
            </a>
          </div>
          <div class="p-body">
            @if($product->brand)
              <div class="p-brand">{{ $product->brand->getTranslation("name", app()->getLocale()) }}</div>
            @endif
            <div class="p-name">
              <a href="{{ route("client.products.detail", ["slug" => $product->canonicalSlug(app()->getLocale())]) }}">
                {{ $product->getTranslation("name", app()->getLocale()) }}
              </a>
            </div>
            
            <ul class="p-specs">
              @if($product->airflow)
                <li>Lưu lượng gió: <strong>{{ number_format($product->airflow) }} m³/h</strong></li>
              @endif
              @if($product->power)
                <li>Công suất: <strong>{{ $product->power }}W</strong></li>
              @elseif($product->voltage)
                <li>Điện áp: <strong>{{ $product->voltage }}V</strong></li>
              @else
                <li>100% dây đồng nguyên chất · Bền bỉ</li>
              @endif
            </ul>

            <div class="p-price">
              @if((float) $product->price > 0)
                {{ number_format((float) $product->price, 0, ",", ".") }}đ
                @if($product->compare_at_price > $product->price)
                  <span class="p-compare-price">{{ number_format((float) $product->compare_at_price, 0, ",", ".") }}đ</span>
                @endif
              @else
                <span style="color:var(--brand-blue);">Liên hệ báo giá</span>
              @endif
            </div>

            <div class="p-bulk">Chiết khấu đại lý &amp; dự án khi mua từ 3 chiếc</div>
            
            <div class="p-card-footer">
              <div class="p-rating">★★★★★ <span>5.0</span></div>
              <div class="p-stock"><span class="d"></span>Sẵn kho</div>
            </div>
          </div>
        </div>
      @empty
        <div class="no-products-box">
          <i class="fas fa-search" style="font-size:36px; color:#94a3b8; margin-bottom:12px;"></i>
          <h3>Không tìm thấy sản phẩm phù hợp</h3>
          <p>Vui lòng thử bỏ bớt tiêu chí lọc hoặc tìm kiếm với từ khóa khác.</p>
          <a href="{{ route("client.products") }}" class="btn-clear-filters-link">Xem toàn bộ sản phẩm</a>
        </div>
      @endforelse
    </div>

    {{-- Phân trang --}}
    @if($products->hasPages())
      <div class="pagination-wrap">
        {{ $products->links() }}
      </div>
    @endif
  </div>
</div>

<script>
function toggleFilterDropdown(id) {
  const current = document.getElementById(id);
  const wasOpen = current.classList.contains("open");
  document.querySelectorAll(".h-filter-dropdown").forEach(d => d.classList.remove("open"));
  if (!wasOpen) {
    current.classList.add("open");
  }
}

// Close when clicking outside
document.addEventListener("click", function(e) {
  if (!e.target.closest(".h-filter-dropdown")) {
    document.querySelectorAll(".h-filter-dropdown").forEach(d => d.classList.remove("open"));
  }
});

function clearFilterCheckboxes(id) {
  const el = document.getElementById(id);
  if (el) {
    el.querySelectorAll("input[type=\x27checkbox\x27]").forEach(cb => cb.checked = false);
    updateFilterCount();
  }
}

function setPriceRange(min, max) {
  document.getElementById("input_min_price").value = min;
  document.getElementById("input_max_price").value = max;
}

function updateFilterCount() {
  const form = document.getElementById("filterForm");
  const formData = new FormData(form);
  const params = new URLSearchParams(formData).toString();
  
  const countBtn = document.getElementById("btn-count-brand");
  if (countBtn) {
    countBtn.textContent = "Đang đếm...";
    fetch("{{ route("client.products.count") }}?" + params)
      .then(res => res.json())
      .then(data => {
        countBtn.textContent = "Xem " + data.count + " sản phẩm";
      })
      .catch(() => {
        countBtn.textContent = "Xem kết quả";
      });
  }
}
</script>
@endsection
