<div class="smart-search-overlay" id="smartSearchModal" style="display:none;">
  <div class="smart-search-dialog">
    <div class="smart-search-header">
      <div class="search-input-wrap">
        <i class="fas fa-search search-lens"></i>
        <input type="text" id="smartSearchInput" class="smart-search-input" placeholder="Tìm tên quạt, model, thương hiệu, thông số..." autocomplete="off">
        <button type="button" class="btn-clear-search" id="btnClearSmartSearch" style="display:none;" onclick="clearSmartSearch()">
          <i class="fas fa-times-circle"></i>
        </button>
      </div>
      <button type="button" class="btn-close-search" onclick="closeSmartSearchModal()" aria-label="Đóng tìm kiếm">
        Đóng
      </button>
    </div>

    <div class="smart-search-body">
      {{-- Gợi ý từ khoá phổ biến --}}
      <div class="smart-search-trending" id="smartSearchTrending">
        <div class="trending-title"><i class="fas fa-fire-flame-curved" style="color:var(--orange);"></i> Tìm kiếm phổ biến:</div>
        <div class="trending-tags">
          <a href="{{ route('client.products', ['q' => 'quạt trần panasonic']) }}" class="trend-pill">Quạt trần Panasonic</a>
          <a href="{{ route('client.products', ['q' => 'quạt cây komasu km-750']) }}" class="trend-pill">Quạt cây Komasu KM-750</a>
          <a href="{{ route('client.products', ['q' => 'quạt thông gió vuông 1380']) }}" class="trend-pill">Quạt vuông 1380x1380</a>
          <a href="{{ route('client.products', ['q' => 'tấm làm mát cooling pad']) }}" class="trend-pill">Tấm làm mát Cooling Pad</a>
          <a href="{{ route('client.products', ['q' => 'quạt ly tâm']) }}" class="trend-pill">Quạt ly tâm hút bụi</a>
          <a href="{{ route('client.products', ['q' => 'vinawind']) }}" class="trend-pill">Vinawind</a>
          <a href="{{ route('client.products', ['q' => 'deton']) }}" class="trend-pill">Deton</a>
        </div>
      </div>

      {{-- Danh mục gợi ý nhanh --}}
      <div class="smart-search-cats" id="smartSearchCats">
        <div class="trending-title"><i class="fas fa-th-list" style="color:var(--brand-blue);"></i> Nhóm sản phẩm chính:</div>
        <div class="quick-cat-chips">
          <a href="{{ route('client.products', ['category' => 'quat-cong-nghiep']) }}" class="cat-chip">Quạt công nghiệp</a>
          <a href="{{ route('client.products', ['category' => 'quat-dan-dung']) }}" class="cat-chip">Quạt dân dụng</a>
          <a href="{{ route('client.products', ['category' => 'quat-thong-gio-vuong']) }}" class="cat-chip">Quạt thông gió</a>
          <a href="{{ route('client.products', ['category' => 'tam-lam-mat-cooling-pad']) }}" class="cat-chip">Làm mát nhà xưởng</a>
          <a href="{{ route('client.calculator') }}" class="cat-chip hot"><i class="fas fa-calculator"></i> Tính chọn quạt</a>
        </div>
      </div>

      {{-- Kết quả Live Search AJAX --}}
      <div class="smart-search-results" id="smartSearchResults" style="display:none;">
        <div class="results-header" id="smartSearchResultsHeader">Gợi ý sản phẩm:</div>
        <div class="results-list" id="smartSearchResultsList"></div>
      </div>
    </div>
  </div>
</div>
