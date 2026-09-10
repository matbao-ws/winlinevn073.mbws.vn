<div class="mobile-cat-sheet-overlay" id="mobileCatSheet" style="display:none;">
  <div class="mobile-cat-sheet-dialog">
    <div class="mobile-cat-sheet-header">
      <div class="sheet-drag-handle"></div>
      <div class="sheet-title-row">
        <div class="sheet-title"><i class="fas fa-th-large" style="color:var(--brand-blue);"></i> Danh mục sản phẩm</div>
        <button type="button" class="sheet-btn-close" onclick="closeMobileCategorySheet()" aria-label="Đóng danh mục">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>

    <div class="mobile-cat-sheet-body">
      @if(isset($globalCategories))
        @foreach($globalCategories as $parent)
          <div class="cat-group-section">
            <div class="cat-group-title">
              @if($parent->image_url)
                <img src="{{ asset($parent->image_url) }}" alt="" class="cat-group-icon">
              @endif
              <span>{{ $parent->getTranslation('name', app()->getLocale()) }}</span>
              <a href="{{ url(app()->getLocale() . '/' . $parent->slug) }}" class="cat-group-all" onclick="closeMobileCategorySheet()">Xem tất cả ›</a>
            </div>
            <div class="cat-grid-tiles">
              @foreach($parent->children as $child)
                <a href="{{ url(app()->getLocale() . '/' . $child->slug) }}" class="cat-tile-item" onclick="closeMobileCategorySheet()">
                  <div class="cat-tile-img-wrap">
                    @if($child->image_url)
                      <img src="{{ asset($child->image_url) }}" alt="{{ $child->getTranslation('name', app()->getLocale()) }}" class="cat-tile-img">
                    @else
                      <i class="fas fa-fan cat-tile-fallback"></i>
                    @endif
                  </div>
                  <span class="cat-tile-name">{{ $child->getTranslation('name', app()->getLocale()) }}</span>
                </a>
              @endforeach
            </div>
          </div>
        @endforeach
      @endif

      <div class="cat-sheet-cta-box">
        <div class="cta-title">Cần tư vấn thiết kế thông gió &amp; làm mát?</div>
        <p class="cta-desc">Kỹ sư Winline khảo sát tận nơi và lên phương án kỹ thuật miễn phí.</p>
        <div class="cta-buttons">
          <a href="tel:0949761893" class="cta-btn call"><i class="fas fa-phone-alt"></i> 0949.761.893</a>
          <a href="https://zalo.me/0949761893" target="_blank" class="cta-btn zalo"><i class="fas fa-comment-dots"></i> Chat Zalo</a>
        </div>
      </div>
    </div>
  </div>
</div>
