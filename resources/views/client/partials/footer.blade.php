<footer class="footer">		
  <!-- Top Blue Bar: Đăng ký nhận tin & Icon mạng xã hội -->
  <div class="tt-footer-default">
    <div class="tt-footer-container">
      <div class="tt-newsletter-wrap">
        <h4 class="tt-collapse-title">Đăng ký nhận tin &amp; Báo giá dự án</h4>
        <form action="{{ route('client.contact.submit') }}" method="post" class="tt-newsletter-form" onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã đăng ký nhận tin từ Winline.vn!');">
          @csrf
          <input type="email" placeholder="Nhập địa chỉ email của bạn..." name="email" required aria-label="Email nhận tin">
          <button type="submit" aria-label="Đăng ký"><i class="fas fa-paper-plane"></i> <span>Đăng ký</span></button>
        </form>
      </div>

      <ul class="tt-social-icon">
        <li><a target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/winlinevietnam" title="Facebook Winline Việt Nam" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
        <li><a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/@winlinevietnam" title="YouTube Winline Việt Nam" aria-label="Youtube"><i class="fab fa-youtube"></i></a></li>
        <li><a target="_blank" rel="noopener noreferrer" href="https://zalo.me/0949761893" title="Zalo Hotline Winline" aria-label="Zalo"><i class="fas fa-comment-dots"></i></a></li>
        <li><a target="_blank" rel="noopener noreferrer" href="https://goo.gl/maps/dwcM2USwK7RCJHFq9" title="Văn phòng Winline trên Google Maps" aria-label="Google Maps"><i class="fas fa-map-marker-alt"></i></a></li>
      </ul>
    </div>
  </div>

  <!-- Main 4 Columns Footer -->
  <div class="site-footer">		
    <div class="site-footer-inner">
      <div class="footer-cols-grid">
        
        <!-- Cột 1: Hỗ trợ khách hàng -->
        <div class="footer-widget">
          <h3><span>Hỗ trợ khách hàng</span></h3>
          <ul class="list-menu">
            <li><a href="{{ route('client.about') }}">Chính sách bảo hành tận nơi</a></li>
            <li><a href="{{ route('client.about') }}">Chính sách đổi trả &amp; hoàn tiền</a></li>
            <li><a href="{{ route('client.about') }}">Chính sách vận chuyển toàn quốc</a></li>
            <li><a href="{{ route('client.about') }}">Phương thức thanh toán &amp; Hóa đơn VAT</a></li>
            <li><a href="{{ route('client.contact') }}">Câu hỏi thường gặp (FAQ)</a></li>
          </ul>
        </div>

        <!-- Cột 2: Về Winline.vn -->
        <div class="footer-widget">
          <h3><span>Thông tin về Winline.vn</span></h3>
          <ul class="list-menu">
            <li><a href="{{ route('client.about') }}">Giới thiệu công ty</a></li>
            <li><a href="{{ route('client.about') }}">Hồ sơ năng lực &amp; CQ/CO</a></li>
            <li><a href="{{ route('client.brands') }}">Thương hiệu phân phối chính hãng</a></li>
            <li><a href="{{ route('client.demands') }}">Chọn theo nhu cầu thông gió xưởng</a></li>
            <li><a href="{{ route('client.calculator') }}">Công cụ tính chọn quạt HVAC</a></li>
            <li><a href="{{ route('client.news') }}">Tin tức &amp; Cẩm nang kỹ thuật HVAC</a></li>
            <li><a href="{{ route('client.about') }}">Chính sách bảo mật thông tin</a></li>
          </ul>
        </div>

        <!-- Cột 3: Liên hệ & Tư vấn -->
        <div class="footer-widget">
          <h3><span>Tổng đài hỗ trợ</span></h3>
          <ul class="list-menu ul-footer-contact">								
            <li><strong>Tư vấn bán hàng &amp; Báo giá dự án:</strong><br>
              <span><i class="fas fa-phone-alt"></i> <a href="tel:0949761893">0949.761.893</a></span>
            </li>
            <li><strong>Hỗ trợ kỹ thuật &amp; Bảo hành:</strong><br>
              <span><i class="fas fa-tools"></i> <a href="tel:0963230665">0963.230.665</a></span>
            </li>
            <li><strong>Email liên hệ:</strong><br>
              <span><i class="fas fa-envelope"></i> <a href="mailto:Winlinevietnam@gmail.com" style="color:#ffffff; font-size:12.5px; font-weight:600; text-decoration:underline;">Winlinevietnam@gmail.com</a></span>
            </li>
            <li><strong>Thời gian làm việc:</strong><br>
              <span style="font-size:12px; color:#cbe2f3;">8h00 - 17h30 (Thứ 2 đến Thứ 7)</span>
            </li>
          </ul>
        </div>

        <!-- Cột 4: Chứng nhận & Thanh toán -->
        <div class="footer-widget">
          <h3><span>Chứng nhận &amp; Thanh toán</span></h3>
          <div class="footer-trust-badges" style="display:flex; align-items:center; gap:12px; margin-bottom:14px; flex-wrap:wrap;">
            <a target="_blank" rel="noopener noreferrer" href="http://online.gov.vn/Home/WebDetails/1109" title="Đã thông báo Bộ Công Thương" class="bocongthuong-link">
              <img src="https://bizweb.dktcdn.net/100/391/557/themes/903209/assets/bocongthuong.png?1786933451521" alt="Đã thông báo Bộ Công Thương" width="135" height="51" loading="lazy" style="height:44px; width:auto; display:block;">
            </a>
            <a href="https://www.dmca.com/Protection/Status.aspx?ID=3f723c36-556b-42f7-a859-5d907c0fa3b5" target="_blank" rel="noopener noreferrer" title="DMCA.com Protection Status" class="dmca-badge" style="margin-top:0;">
              <img src="https://images.dmca.com/Badges/dmca-badge-w100-2x1-02.png?ID=3f723c36-556b-42f7-a859-5d907c0fa3b5" alt="DMCA.com Protection Status" width="105" height="24" loading="lazy" style="height:24px; width:auto; display:block;">
            </a>
          </div>
          
          <div style="font-size:12px; font-weight:700; color:#ffffff; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.03em;">Chấp nhận thanh toán</div>
          <div class="payment-methods-grid" style="display:flex; gap:6px; flex-wrap:wrap; margin-bottom:14px;">
            <span style="background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.22); border-radius:4px; padding:4px 8px; font-size:11px; font-weight:600; color:#ffffff; display:inline-flex; align-items:center; gap:4px;"><i class="fas fa-university" style="color:#ffffff;"></i> Chuyển khoản</span>
            <span style="background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.22); border-radius:4px; padding:4px 8px; font-size:11px; font-weight:600; color:#ffffff; display:inline-flex; align-items:center; gap:4px;"><i class="fas fa-money-bill-wave" style="color:#86efac;"></i> Tiền mặt (COD)</span>
            <span style="background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.22); border-radius:4px; padding:4px 8px; font-size:11px; font-weight:600; color:#ffffff; display:inline-flex; align-items:center; gap:4px;"><i class="fas fa-qrcode" style="color:#fca5a5;"></i> VNPAY-QR</span>
            <span style="background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.22); border-radius:4px; padding:4px 8px; font-size:11px; font-weight:600; color:#ffffff; display:inline-flex; align-items:center; gap:4px;"><i class="fas fa-credit-card" style="color:#fde047;"></i> Thẻ ATM / Visa</span>
          </div>

          <div style="font-size:11.5px; color:#e0f2fe; line-height:1.6;">
            <div style="display:flex; align-items:center; gap:6px; margin-bottom:4px;"><i class="fas fa-shield-alt" style="color:#86efac;"></i> Cam kết 100% chính hãng, có CO/CQ</div>
            <div style="display:flex; align-items:center; gap:6px;"><i class="fas fa-truck" style="color:#ffffff;"></i> Giao hàng hỏa tốc toàn quốc</div>
          </div>
        </div>

      </div>

      <!-- Khối thông tin pháp lý doanh nghiệp -->
      <div class="fot-col-bottom">
        <p><strong>Công ty TNHH Winline Việt Nam</strong> - Giấy chứng nhận ĐKKD &amp; MST: <strong>0106085370</strong> do Sở KH &amp; ĐT TP Hà Nội cấp ngày 15/01/2013.</p>
        <p><strong>Địa chỉ ĐKKD:</strong> Số 7 BT6, Khu đô thị Pháp Vân - Tứ Hiệp, Phường Hoàng Liệt, Quận Hoàng Mai, TP Hà Nội.</p>
        <p><strong>Cửa hàng &amp; VPGD:</strong> Số 17, ngõ 46, Quan Nhân, Phường Thanh Xuân, TP Hà Nội - Hotline: <strong>0949.761.893</strong> - Email: <strong>Winlinevietnam@gmail.com</strong></p>
        <p style="color:#cbe2f3; font-size:11.5px; margin-top:8px;">Hệ thống Website: <a href="https://winline.vn" target="_blank" style="color:#ffffff;text-decoration:underline;">Winline.vn</a> | <a href="https://quatdiencothongnhat.vn" target="_blank" style="color:#ffffff;text-decoration:underline;">Quatdiencothongnhat.vn</a> | <a href="https://chinghaihanoi.vn" target="_blank" style="color:#ffffff;text-decoration:underline;">Chinghaihanoi.vn</a> | <a href="https://quatdienco.vn" target="_blank" style="color:#ffffff;text-decoration:underline;">Quatdienco.vn</a></p>
      </div>

    </div>
  </div>	

  <!-- Copyright -->
  <div class="copyright">
    <span>&copy; 2026 Bản quyền thuộc về <strong>Công ty TNHH Winline Việt Nam</strong>. Tất cả quyền được bảo lưu.</span>
  </div>
</footer>
