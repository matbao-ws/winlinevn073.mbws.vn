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
          @php
            $catThumbMap = [
              'quat-tran' => 'client-assets/images/v8/quat_tran.jpg',
              'quat-cay' => 'client-assets/images/v8/quat_dung.jpg',
              'quat-cay-cong-nghiep' => 'client-assets/images/v8/quat_cong_nghiep.jpg',
              'quat-treo-tuong' => 'client-assets/images/v8/quat_treo_tuong.jpg',
              'quat-treo-cong-nghiep' => 'client-assets/images/v8/quat_cong_nghiep.jpg',
              'quat-dao-tran' => 'client-assets/images/v8/quat_tran.jpg',
              'quat-hop' => 'client-assets/images/v8/quat_hop.jpg',
              'quat-san' => 'client-assets/images/v8/quat_de_ban.jpg',
              'quat-san-cong-nghiep' => 'client-assets/images/v8/quat_cong_nghiep.jpg',
              'quat-thong-gio' => 'client-assets/images/v8/quat_thong_gio.jpg',
              'quat-thong-gio-vuong' => 'client-assets/images/v8/quat_hut_cong_nghiep.jpg',
              'quat-hut-xach-tay' => 'client-assets/images/v8/quat_ong_gio.jpg',
              'quat-ly-tam' => 'client-assets/images/v8/quat_ong_gio.jpg',
              'quat-huong-truc' => 'client-assets/images/v8/quat_chuyen_dung.jpg',
              'tam-lam-mat-cooling-pad' => 'client-assets/images/v8/demand_coolingpad.jpg',
              'may-lam-mat-cong-nghiep' => 'client-assets/images/v8/quat_phun_suong.jpg',
              'quat-cat-gio' => 'client-assets/images/v8/quat_cat_gio.jpg',
              'quat-cap-khi-tuoi-erv' => 'client-assets/images/v8/quat_ong_gio.jpg',
            ];
          @endphp
          @if(isset($globalCategories) && $globalCategories->isNotEmpty())
            @foreach($globalCategories as $parent)
              <div class="mega-col">
                <a href="{{ url(app()->getLocale() . '/' . $parent->slug) }}" class="mega-col-title-link">
                  @php
                    $pImg = $parent->image_url ?: ($catThumbMap[$parent->slug] ?? null);
                  @endphp
                  @if($pImg)
                    <img src="{{ asset($pImg) }}" alt="" class="mega-cat-img-l1">
                  @endif
                  <div class="mega-col-title-text">{{ $parent->getTranslation('name', app()->getLocale()) }}</div>
                </a>
                <div class="mega-sub-list">
                  @foreach($parent->children as $child)
                    @php
                      $cImg = $child->image_url ?: ($catThumbMap[$child->slug] ?? 'client-assets/images/placeholder.png');
                    @endphp
                    <a href="{{ url(app()->getLocale() . '/' . $child->slug) }}" class="mega-item-l2">
                      <img src="{{ asset($cImg) }}" alt="{{ $child->getTranslation('name', app()->getLocale()) }}" class="mega-cat-img-l2">
                      <span class="mega-item-title">{{ $child->getTranslation('name', app()->getLocale()) }}</span>
                    </a>
                  @endforeach
                </div>
              </div>
            @endforeach
          @endif

          <div class="mega-col mega-col-featured">
            <div class="mega-col-title"><i class="fas fa-certificate" style="color:var(--brand-blue, #004e7d);"></i> Thương hiệu chính hãng</div>
            <div class="mega-brand-pills">
              @if(isset($globalBrands))
                @foreach($globalBrands->take(10) as $b)
                  <a href="{{ url(app()->getLocale() . '/' . ($b->canonicalSlug(app()->getLocale()) ?: $b->slug)) }}" class="mb-pill" title="Quạt {{ $b->getTranslation('name', app()->getLocale()) }} chính hãng">
                    {{ $b->getTranslation('name', app()->getLocale()) }}
                  </a>
                @endforeach
              @endif
            </div>
            <div class="mega-promo-box">
              <div class="mp-tag">CHIẾT KHẤU DOANH NGHIỆP</div>
              <p class="mp-text">Chiết khấu tốt nhất cho đơn hàng số lượng lớn, dự án &amp; nhà thầu M&amp;E.</p>
              <a href="tel:0949761893" class="mp-btn"><i class="fas fa-phone-alt"></i> 0949.761.893</a>
            </div>
            <a href="{{ route('client.brands') }}" class="mega-view-all">Xem tất cả thương hiệu <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </div>

    <!-- 2. Giới thiệu -->
    <a href="{{ route('client.about') }}" class="nav-top {{ request()->routeIs('client.about') ? 'active' : '' }}">Giới thiệu</a>

    <!-- 3. Chọn theo nhu cầu -->
    <a href="{{ route('client.demands') }}" class="nav-top {{ request()->routeIs('client.solutions') || request()->routeIs('client.demands') ? 'active' : '' }}">Chọn theo nhu cầu</a>

    <!-- 4. Thương hiệu -->
    <a href="{{ route('client.brands') }}" class="nav-top {{ request()->routeIs('client.brands') ? 'active' : '' }}">Thương hiệu</a>

    <!-- 5. Công cụ tính quạt -->
    <a href="{{ route('client.calculator') }}" class="nav-top {{ request()->routeIs('client.calculator') ? 'active' : '' }}"><i class="fas fa-calculator" style="color:var(--orange);"></i> Công cụ tính quạt</a>

    <!-- 6. Tin tức & tư vấn -->
    <div class="nav-drop">
      <a href="{{ route('client.news') }}" class="nav-top {{ request()->routeIs('client.news*') ? 'active' : '' }}">
        Tin tức &amp; tư vấn <i class="fas fa-chevron-down nav-arrow"></i>
      </a>
      <div class="nav-panel" style="min-width:240px; padding:8px 0;">
        <a href="{{ route('client.about') }}"><i class="fas fa-file-invoice" style="margin-right:8px;color:var(--brand-blue);"></i> Hồ sơ năng lực &amp; CQ/CO</a>
        <a href="{{ route('client.about') }}"><i class="fas fa-shield-alt" style="margin-right:8px;color:var(--brand-blue);"></i> Chính sách bảo hành tận nơi</a>
        <a href="{{ route('client.about') }}"><i class="fas fa-truck-fast" style="margin-right:8px;color:var(--brand-blue);"></i> Chính sách giao hàng toàn quốc</a>
        <a href="{{ route('client.contact') }}"><i class="fas fa-circle-question" style="margin-right:8px;color:var(--brand-blue);"></i> Câu hỏi thường gặp (FAQ)</a>
        <a href="{{ route('client.contact') }}"><i class="fas fa-headset" style="margin-right:8px;color:var(--brand-blue);"></i> Trung tâm hỗ trợ &amp; Liên hệ</a>
      </div>
    </div>

    <!-- 7. Liên hệ & Báo giá -->
    <a href="{{ route('client.contact') }}" class="nav-top {{ request()->routeIs('client.contact') ? 'active' : '' }}">Liên hệ &amp; Báo giá</a>
  </div>
</nav>
