<header class="site">
  <div class="header-inner">
    <div class="header-mobile-top-row">
      <button onclick="toggleMobileDrawer()" class="mobile-menu-btn" aria-label="Mở danh mục menu">
        <i class="fas fa-bars"></i>
      </button>
      <a href="{{ route('client.home') }}" class="site-logo-wrap" aria-label="Trang chủ Winline.vn">
        <img src="{{ asset('client-assets/images/logo.png') }}" alt="Winline Việt Nam" class="site-logo-img">
      </a>
      <div class="header-actions">
        <a href="tel:0949761893" class="item" aria-label="Gọi hotline">
          <div class="icon"><i class="fas fa-phone-volume"></i></div>
          <span class="desktop-only-label">Gọi ngay</span>
        </a>
        <div onclick="openCartDrawer()" class="item" style="cursor:pointer;" aria-label="Giỏ hàng">
          <div class="icon" style="position:relative;">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-badge-count" style="position:absolute; top:-6px; right:-8px; background:var(--orange); color:#fff; font-size:10px; font-weight:700; width:17px; height:17px; border-radius:50%; display:none; align-items:center; justify-content:center;">0</span>
          </div>
          <span class="desktop-only-label">Giỏ hàng</span>
        </div>
      </div>
    </div>
    
    <div class="search-wrap">
      <form action="{{ route('client.products') }}" method="GET" style="display:flex; width:100%; position:relative;">
        <input class="search-box header-search-input" name="q" value="{{ request('q') }}" type="text" placeholder="Tìm kiếm quạt công nghiệp, quạt ly tâm, quạt thông gió, quạt cây...">
        <button class="search-btn" type="submit" aria-label="Tìm kiếm"><i class="fas fa-search"></i></button>
      </form>
    </div>
  </div>
</header>

<nav class="catnav">
  <div class="catnav-inner">
    <!-- 1. Danh mục sản phẩm (Mega Menu Đa Cấp) -->
    <div class="nav-drop">
      <a href="{{ route('client.products') }}" class="nav-top {{ request()->routeIs('client.products*') ? 'active' : '' }}">
        <i class="fas fa-bars-staggered"></i> Danh mục sản phẩm <i class="fas fa-chevron-down nav-arrow"></i>
      </a>
      <div class="nav-mega-panel">
        <div class="mega-inner">
          @if(isset($globalCategories) && $globalCategories->isNotEmpty())
            @foreach($globalCategories as $parent)
              <div class="mega-col">
                <a href="{{ route('client.products', ['category' => $parent->slug]) }}" class="mega-col-title-link">
                  @if($parent->image_url)
                    <img src="{{ asset($parent->image_url) }}" alt="" class="mega-cat-img-l1">
                  @endif
                  <div class="mega-col-title-text">{{ $parent->getTranslation('name', app()->getLocale()) }}</div>
                </a>
                <div class="mega-sub-list">
                  @foreach($parent->children as $child)
                    <a href="{{ route('client.products', ['category' => $child->slug]) }}" class="mega-item-l2">
                      @if($child->image_url)
                        <img src="{{ asset($child->image_url) }}" alt="" class="mega-cat-img-l2">
                      @endif
                      <span class="mega-item-title">{{ $child->getTranslation('name', app()->getLocale()) }}</span>
                    </a>
                  @endforeach
                </div>
              </div>
            @endforeach
          @endif

          <div class="mega-col mega-col-featured">
            <div class="mega-col-title"><i class="fas fa-star" style="color:#f59e0b;"></i> Thương hiệu &amp; Dự án</div>
            <div class="mega-brand-pills">
              @if(isset($globalBrands))
                @foreach($globalBrands->take(8) as $b)
                  <a href="{{ route('client.products', ['brand' => $b->slug]) }}" class="mb-pill">
                    @if($b->image_url)
                      <img src="{{ asset($b->image_url) }}" alt="{{ $b->getTranslation('name', app()->getLocale()) }}" style="height:14px; max-width:55px; object-fit:contain;">
                    @else
                      {{ $b->getTranslation('name', app()->getLocale()) }}
                    @endif
                  </a>
                @endforeach
              @endif
            </div>
            <div class="mega-promo-box">
              <div class="mp-tag">CHIẾT KHẤU DỰ ÁN</div>
              <p class="mp-text">Chiết khấu tốt nhất cho đơn hàng số lượng lớn &amp; nhà thầu M&amp;E.</p>
              <a href="tel:0949761893" class="mp-btn"><i class="fas fa-phone-alt"></i> 0949.761.893</a>
            </div>
            <a href="{{ route('client.products') }}" class="mega-view-all">Xem toàn bộ sản phẩm <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </div>

    <!-- 2. Giới thiệu -->
    <a href="{{ route('client.about') }}" class="nav-top {{ request()->routeIs('client.about') ? 'active' : '' }}">Giới thiệu</a>

    <!-- 3. Chọn theo nhu cầu -->
    <a href="{{ route('client.demands') }}" class="nav-top {{ request()->routeIs('client.solutions') || request()->routeIs('client.demands') ? 'active' : '' }}">Chọn theo nhu cầu</a>

    <!-- 4. Dự án -->
    <a href="{{ route('client.projects') }}" class="nav-top {{ request()->routeIs('client.projects') ? 'active' : '' }}">Dự án</a>

    <!-- 5. Công cụ tính quạt -->
    <a href="{{ route('client.calculator') }}" class="nav-top {{ request()->routeIs('client.calculator') ? 'active' : '' }}"><i class="fas fa-calculator" style="color:var(--orange);"></i> Công cụ tính quạt</a>

    <!-- 6. Thương hiệu -->
    <a href="{{ route('client.brands') }}" class="nav-top {{ request()->routeIs('client.brands') ? 'active' : '' }}">Thương hiệu</a>

    <!-- 7. Tin tức & Hỗ trợ -->
    <div class="nav-drop">
      <a href="{{ route('client.news') }}" class="nav-top {{ request()->routeIs('client.news*') ? 'active' : '' }}">
        Tin tức &amp; Hỗ trợ <i class="fas fa-chevron-down nav-arrow"></i>
      </a>
      <div class="nav-panel" style="min-width:240px; padding:8px 0;">
        <a href="{{ route('client.about') }}"><i class="fas fa-file-invoice" style="margin-right:8px;color:var(--brand-blue);"></i> Hồ sơ năng lực &amp; CQ/CO</a>
        <a href="{{ route('client.about') }}"><i class="fas fa-shield-alt" style="margin-right:8px;color:var(--brand-blue);"></i> Chính sách bảo hành tận nơi</a>
        <a href="{{ route('client.about') }}"><i class="fas fa-truck-fast" style="margin-right:8px;color:var(--brand-blue);"></i> Chính sách giao hàng toàn quốc</a>
        <a href="{{ route('client.contact') }}"><i class="fas fa-circle-question" style="margin-right:8px;color:var(--brand-blue);"></i> Câu hỏi thường gặp (FAQ)</a>
        <a href="{{ route('client.contact') }}"><i class="fas fa-headset" style="margin-right:8px;color:var(--brand-blue);"></i> Trung tâm hỗ trợ &amp; Liên hệ</a>
      </div>
    </div>

    <!-- 8. Liên hệ & Báo giá -->
    <a href="{{ route('client.contact') }}" class="nav-top {{ request()->routeIs('client.contact') ? 'active' : '' }}">Liên hệ &amp; Báo giá</a>
  </div>
</nav>
