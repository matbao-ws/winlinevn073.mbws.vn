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
          <div class="mega-col">
            <div class="mega-col-title"><i class="fas fa-fan"></i> Quạt dân dụng</div>
            <a href="{{ route('client.products', ['category' => 'quat-dan-dung']) }}"><i class="fas fa-angle-right"></i> Quạt trần &amp; đảo trần</a>
            <a href="{{ route('client.products', ['category' => 'quat-dan-dung']) }}"><i class="fas fa-angle-right"></i> Quạt cây / quạt đứng gia đình</a>
            <a href="{{ route('client.products', ['category' => 'quat-dan-dung']) }}"><i class="fas fa-angle-right"></i> Quạt treo tường gia đình</a>
            <a href="{{ route('client.products', ['category' => 'quat-dan-dung']) }}"><i class="fas fa-angle-right"></i> Quạt sàn / quạt chân quỳ</a>
            <a href="{{ route('client.products', ['category' => 'quat-dan-dung']) }}"><i class="fas fa-angle-right"></i> Quạt hộp &amp; quạt bàn</a>
            <a href="{{ route('client.products', ['category' => 'quat-dan-dung']) }}"><i class="fas fa-angle-right"></i> Quạt tháp &amp; quạt không cánh</a>
          </div>
          <div class="mega-col">
            <div class="mega-col-title"><i class="fas fa-wind"></i> Quạt công nghiệp</div>
            <a href="{{ route('client.products', ['category' => 'quat-cong-nghiep']) }}"><i class="fas fa-angle-right"></i> Quạt cây công nghiệp (KM-750, DHF-750)</a>
            <a href="{{ route('client.products', ['category' => 'quat-cong-nghiep']) }}"><i class="fas fa-angle-right"></i> Quạt treo tường công nghiệp</a>
            <a href="{{ route('client.products', ['category' => 'quat-thong-gio-cong-nghiep']) }}"><i class="fas fa-angle-right"></i> Quạt thông gió vuông trang trại &amp; xưởng</a>
            <a href="{{ route('client.products', ['category' => 'quat-ly-tam']) }}"><i class="fas fa-angle-right"></i> Quạt ly tâm hút bụi &amp; hút khói PCCC</a>
            <a href="{{ route('client.products', ['category' => 'quat-huong-truc']) }}"><i class="fas fa-angle-right"></i> Quạt hướng trục tăng áp buồng thang</a>
            <a href="{{ route('client.products', ['category' => 'quat-cong-nghiep']) }}"><i class="fas fa-angle-right"></i> Quạt hút xách tay có ống nối gió</a>
          </div>
          <div class="mega-col">
            <div class="mega-col-title"><i class="fas fa-temperature-low"></i> Thông gió &amp; Làm mát</div>
            <a href="{{ route('client.products', ['category' => 'may-lam-mat-cong-nghiep']) }}"><i class="fas fa-angle-right"></i> Máy làm mát công nghiệp Air Cooler</a>
            <a href="{{ route('client.products', ['category' => 'quat-thong-gio-cong-nghiep']) }}"><i class="fas fa-angle-right"></i> Quạt thông gió gắn tường &amp; âm trần</a>
            <a href="{{ route('client.products', ['category' => 'he-thong-thong-gio-lam-mat']) }}"><i class="fas fa-angle-right"></i> Quạt cắt gió (Air Curtain) chống thoát nhiệt</a>
            <a href="{{ route('client.products', ['category' => 'tam-lam-mat-cooling-pad']) }}"><i class="fas fa-angle-right"></i> Tấm làm mát Cooling Pad</a>
            <a href="{{ route('client.products', ['category' => 'he-thong-thong-gio-lam-mat']) }}"><i class="fas fa-angle-right"></i> Quạt thu hồi nhiệt ERV Nedfon</a>
            <a href="{{ route('client.products', ['category' => 'he-thong-thong-gio-lam-mat']) }}"><i class="fas fa-angle-right"></i> Ống gió mềm &amp; phụ kiện thông gió</a>
          </div>
          <div class="mega-col mega-col-featured">
            <div class="mega-col-title"><i class="fas fa-star"></i> Thương hiệu &amp; Dự án</div>
            <div class="mega-brand-pills">
              <a href="{{ route('client.products', ['brand' => 'komasu']) }}" class="mb-pill">Komasu</a>
              <a href="{{ route('client.products', ['brand' => 'panasonic']) }}" class="mb-pill">Panasonic</a>
              <a href="{{ route('client.products', ['brand' => 'vinawind']) }}" class="mb-pill">Vinawind</a>
              <a href="{{ route('client.products', ['brand' => 'deton']) }}" class="mb-pill">Deton</a>
              <a href="{{ route('client.products', ['brand' => 'dasin']) }}" class="mb-pill">Dasin</a>
              <a href="{{ route('client.products', ['brand' => 'chinghai']) }}" class="mb-pill">Chinghai</a>
            </div>
            <div class="mega-promo-box">
              <div class="mp-tag">CHIẾT KHẤU DỰ ÁN</div>
              <p class="mp-text">Chiết khấu tốt nhất cho đơn hàng từ 6 sản phẩm &amp; nhà thầu M&amp;E.</p>
              <a href="tel:0949761893" class="mp-btn"><i class="fas fa-phone-alt"></i> 0949.761.893</a>
            </div>
            <a href="{{ route('client.products') }}" class="mega-view-all">Xem toàn bộ 339+ sản phẩm <i class="fas fa-arrow-right"></i></a>
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
