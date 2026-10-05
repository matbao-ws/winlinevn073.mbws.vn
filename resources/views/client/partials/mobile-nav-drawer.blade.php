<div class="mobile-drawer-backdrop" id="mobileNavDrawer" style="display:none;">
  <div class="mobile-drawer-panel">
    <div class="mobile-drawer-head">
      <a href="{{ route('client.home') }}" class="site-logo-wrap" onclick="closeMobileNavDrawer()">
        <img src="{{ asset('client-assets/images/logo.png') }}" alt="Winline Việt Nam" class="site-logo-img">
      </a>
      <button onclick="closeMobileNavDrawer()" class="mobile-drawer-close" aria-label="Đóng menu">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="mobile-drawer-hotline-box">
      <div>
        <div class="label">Hotline tư vấn 24/7</div>
        <a href="tel:0949761893" class="phone">0949.761.893</a>
      </div>
      <a href="tel:0949761893" class="call-btn">
        <i class="fas fa-phone-alt"></i> Gọi ngay
      </a>
    </div>

    <div class="mobile-drawer-nav">
      <div class="mobile-nav-group-title">Menu chính</div>
      
      <a href="{{ route('client.about') }}" class="mobile-drawer-link" onclick="closeMobileNavDrawer()">
        <span><i class="fas fa-circle-info icon-lead"></i> Giới thiệu Winline</span>
        <i class="fas fa-chevron-right arrow"></i>
      </a>

      <a href="{{ route('client.demands') }}" class="mobile-drawer-link" onclick="closeMobileNavDrawer()">
        <span><i class="fas fa-sliders icon-lead"></i> Chọn theo nhu cầu</span>
        <i class="fas fa-chevron-right arrow"></i>
      </a>

      <a href="{{ route('client.calculator') }}" class="mobile-drawer-link hot-item" onclick="closeMobileNavDrawer()">
        <span><i class="fas fa-calculator icon-lead" style="color:#f59e0b;"></i> Công cụ tính quạt HVAC</span>
        <span class="badge-hot">HOT</span>
      </a>

      <a href="{{ route('client.brands') }}" class="mobile-drawer-link" onclick="closeMobileNavDrawer()">
        <span><i class="fas fa-award icon-lead"></i> Thương hiệu phân phối</span>
        <i class="fas fa-chevron-right arrow"></i>
      </a>

      <a href="{{ route('client.news') }}" class="mobile-drawer-link" onclick="closeMobileNavDrawer()">
        <span><i class="fas fa-newspaper icon-lead"></i> Tin tức &amp; Kỹ thuật</span>
        <i class="fas fa-chevron-right arrow"></i>
      </a>

      <a href="{{ route('client.contact') }}" class="mobile-drawer-link" onclick="closeMobileNavDrawer()">
        <span><i class="fas fa-envelope-open-text icon-lead"></i> Liên hệ &amp; Báo giá</span>
        <i class="fas fa-chevron-right arrow"></i>
      </a>

      <div class="mobile-drawer-footer-box">
        <div class="company-name">CÔNG TY TNHH WINLINE VIỆT NAM</div>
        <div class="company-addr">
          <i class="fas fa-location-dot"></i> Số 7 BT6, Khu đô thị Pháp Vân – Tứ Hiệp, Hoàng Mai, Hà Nội.<br>
          <i class="fas fa-clock"></i> 8:00 - 18:00 (Thứ 2 - Thứ 7)<br>
          <i class="fas fa-certificate"></i> Đầy đủ hoá đơn VAT &amp; chứng chỉ xuất xưởng CO/CQ.
        </div>
      </div>
    </div>
  </div>
</div>
