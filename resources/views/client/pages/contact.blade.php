@extends('client.layouts.app')

@section('title', 'Liên Hệ & Văn Phòng Giao Dịch Winline | Winline.vn')

@push('styles')
<style>
:root {
  --navy-950:#00354f;
  --navy-800:#004e7d;
  --navy-700:#1f6690;
  --navy-100: #e6eef3;
  --paper: #f7f8fa;
  --white: #ffffff;
  --ink: #1a2230;
  --ink-soft: #5c6773;
  --line: #dde3ea;
  --orange: #d41e3d;
  --orange-dark: #a71830;
  --orange-100: #f4e6e9;
  --green: #1e8a5f;
  --radius: 6px;
  --shadow: 0 2px 10px rgba(13, 31, 51, 0.08);
}
* { box-sizing: border-box; }
html, body { margin: 0; padding: 0; overflow-x: hidden; max-width: 100%; }
body {
  font-family: 'Be Vietnam Pro', system-ui, sans-serif;
  color: var(--ink);
  background: var(--paper);
  font-size: 15px;
  line-height: 1.5;
}
.mono { font-family: 'IBM Plex Mono', monospace; }
a { color: inherit; text-decoration: none; }
img { max-width: 100%; display: block; }
button { font-family: inherit; cursor: pointer; }

/* ---------- utility bar ---------- */













/* ---------- breadcrumb ---------- */
.breadcrumb {
  max-width: 1240px;
  margin: 0 auto;
  padding: 14px 20px 0;
  font-size: 12.5px;
  color: var(--ink-soft);
}
.breadcrumb a:hover {
  color: var(--navy-800);
  text-decoration: underline;
}

/* ---------- contact main layout ---------- */
.contact-wrap {
  max-width: 1240px;
  margin: 0 auto;
  padding: 24px 20px 60px;
}
.contact-grid {
  display: grid;
  grid-template-columns: 460px 1fr;
  gap: 26px;
  align-items: start;
}
@media (max-width: 960px) {
  .contact-grid {
    grid-template-columns: 1fr;
  }
}

.contact-card {
  background: #ffffff;
  border: 1px solid var(--line);
  border-radius: 12px;
  padding: 26px 28px;
  box-shadow: var(--shadow);
  margin-bottom: 24px;
}
.contact-card h1, .contact-card h2 {
  font-size: 19px;
  color: var(--navy-950);
  margin: 0 0 16px;
  padding-bottom: 12px;
  border-bottom: 1px solid var(--line);
  font-weight: 700;
}
.contact-item {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  margin-bottom: 16px;
  font-size: 13.5px;
  line-height: 1.55;
}
.contact-item:last-child { margin-bottom: 0; }
.contact-icon {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  background: var(--navy-100);
  color: var(--navy-800);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 15px;
  flex-shrink: 0;
  margin-top: 2px;
}
.contact-icon.red { background: var(--orange-100); color: var(--orange); }
.contact-icon.green { background: #e6f4ee; color: var(--green); }
.contact-info strong {
  display: block;
  color: var(--navy-950);
  font-size: 13.5px;
  margin-bottom: 2px;
}
.contact-info p {
  margin: 0;
  color: var(--ink-soft);
}
.contact-info .hotline-num {
  font-size: 16px;
  font-weight: 700;
  color: var(--orange);
  font-family: 'IBM Plex Mono', monospace;
}

/* Contact Form */
.form-group {
  margin-bottom: 14px;
}
.form-group label {
  display: block;
  font-size: 13px;
  font-weight: 600;
  color: var(--navy-950);
  margin-bottom: 6px;
}
.form-input {
  width: 100%;
  padding: 10px 14px;
  border: 1.5px solid var(--line);
  border-radius: 6px;
  font-size: 13.5px;
  font-family: inherit;
  background: var(--paper);
  color: var(--ink);
  transition: border-color 0.2s;
}
.form-input:focus {
  outline: none;
  border-color: var(--navy-800);
  background: #ffffff;
}
.btn-submit {
  width: 100%;
  background: var(--orange);
  color: #ffffff;
  border: none;
  border-radius: 6px;
  padding: 13px 20px;
  font-size: 14.5px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: background-color 0.2s;
}
.btn-submit:hover {
  background: var(--orange-dark);
}

/* Map Card */
.map-card {
  background: #ffffff;
  border: 1px solid var(--line);
  border-radius: 12px;
  padding: 20px;
  box-shadow: var(--shadow);
  height: 680px;
  display: flex;
  flex-direction: column;
}
@media (max-width: 960px) {
  .map-card { height: 460px; }
}
.map-title {
  font-size: 15px;
  font-weight: 700;
  color: var(--navy-950);
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.map-frame-wrap {
  flex: 1;
  border-radius: 8px;
  overflow: hidden;
  border: 1px solid var(--line);
}
.map-frame-wrap iframe {
  width: 100%;
  height: 100%;
  border: 0;
}

/* ---------- site 

@media (max-width: 860px) {
  
}
.
.
.
.
</style>
@endpush

@section('content')
<!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="{{ route('client.home') }}">Trang chủ</a> &rsaquo; <span>Liên hệ &amp; Văn phòng giao dịch</span>
  </div>

  <!-- Main Content Layout -->
  <main class="contact-wrap">
    <div class="contact-grid">

      <!-- Left Column: Company Info & Consultation Form -->
      <div>
        
        <!-- Info Card -->
        <div class="contact-card">
          <h1>Thông Tin Liên Hệ Winline Việt Nam</h1>

          <div class="contact-item">
            <div class="contact-icon red"><i class="fas fa-map-marker-alt"></i></div>
            <div class="contact-info">
              <strong>Showroom &amp; Văn Phòng Giao Dịch:</strong>
              <p>Số 17, Ngõ 46 Quan Nhân, Phường Thanh Xuân, TP. Hà Nội</p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class="fas fa-building"></i></div>
            <div class="contact-info">
              <strong>Trụ Sở Đăng Ký Doanh Nghiệp:</strong>
              <p>Số 7 BT6, Khu đô thị Pháp Vân - Tứ Hiệp, Phường Hoàng Liệt, Quận Hoàng Mai, TP. Hà Nội</p>
              <p style="font-size:12px; margin-top:3px; color:var(--ink-soft);">MST: <span class="mono" style="font-weight:600; color:var(--navy-950);">0106085370</span> (Cấp ngày 15/01/2013 bởi Sở KH&amp;ĐT TP Hà Nội)</p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon red"><i class="fas fa-phone-alt"></i></div>
            <div class="contact-info">
              <strong>Hotline Bán Hàng &amp; Dự Án:</strong>
              <p class="hotline-num">0949.761.893</p>
              <p style="font-size:12px; color:var(--green); font-weight:600;"><i class="fas fa-check-circle"></i> Hỗ trợ tư vấn Zalo &amp; Báo giá 24/7</p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class="fas fa-headset"></i></div>
            <div class="contact-info">
              <strong>Tổng Đài &amp; Hỗ Trợ Kỹ Thuật:</strong>
              <p style="font-weight:600; color:var(--navy-950);">1900 099 806 &mdash; Bảo hành: 0963.230.665</p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
            <div class="contact-info">
              <strong>Email Tiếp Nhận Hồ Sơ / Báo Giá:</strong>
              <p class="mono" style="color:var(--navy-800); font-weight:600;">Winlinevietnam@gmail.com</p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon green"><i class="fas fa-clock"></i></div>
            <div class="contact-info">
              <strong>Thời Gian Làm Việc:</strong>
              <p>Thứ 2 &ndash; Thứ 7: 8h00 &ndash; 17h30 (Chủ nhật hỗ trợ qua Hotline/Zalo)</p>
            </div>
          </div>
        </div>

        <!-- Quote / Consultation Form -->
        <div class="contact-card">
          @if(session('success'))
            <div style="background:#e6f4ee; color:#1e8a5f; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-weight:600;">
              <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
          @endif
          <form action="{{ route('client.contact.submit') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Họ và tên của bạn <span style="color:var(--orange);">*</span></label>
              <input type="text" name="name" class="form-input" placeholder="Ví dụ: Nguyễn Văn A" value="{{ old('name') }}" required>
              @error('name') <span style="color:#d41e3d; font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label>Số điện thoại liên hệ <span style="color:var(--orange);">*</span></label>
              <input type="tel" name="phone" class="form-input" placeholder="Ví dụ: 0912.345.678" value="{{ old('phone') }}" required>
              @error('phone') <span style="color:#d41e3d; font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label>Email nhận bảng báo giá</label>
              <input type="email" name="email" class="form-input" placeholder="email@congty.com" value="{{ old('email') }}">
              @error('email') <span style="color:#d41e3d; font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label>Tên đơn vị / Dự án / Công ty (nếu có)</label>
              <input type="text" name="subject" class="form-input" placeholder="Tên xưởng may, kho hàng hoặc công ty..." value="{{ old('subject') }}">
            </div>

            <div class="form-group">
              <label>Nội dung cần tư vấn hoặc danh mục quạt cần báo giá</label>
              <textarea name="message" rows="4" class="form-input" placeholder="Ví dụ: Cần báo giá 10 quạt vuông 1380, 5 máy làm mát 18000 cho xưởng 1200m2 tại Bắc Ninh...">{{ old('message') }}</textarea>
              @error('message') <span style="color:#d41e3d; font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-submit">
              <i class="fas fa-paper-plane"></i> Gửi Yêu Cầu Báo Giá Ngay
            </button>
          </form>
        </div>

      </div>

      <!-- Right Column: Interactive Google Map -->
      <div>
        <div class="map-card">
          <div class="map-title">
            <i class="fas fa-map-marked-alt" style="color:var(--orange);"></i>
            <span>Bản Đồ Chỉ Đường Đến Showroom Winline Hà Nội</span>
          </div>
          <div class="map-frame-wrap">
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.636906297371!2d105.80775317587002!3d21.00718718851724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac9e05f63901%3A0xe13fa178e2dc40d6!2zMTcgTmcuIDQ2IFF1YW4gTmjDom4sIE5ow6JuIENow61uaCwgVGhhbmggWHXDom4sIEjDoCBO4buZaQ!5e0!3m2!1svi!2svn!4v1700000000000!5m2!1svi!2svn" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>
      </div>

    </div>
  </main>

  <!-- Site Footer -->
  <!-- UNIVERSAL MASTER FOOTER (COMPACT & MODERN - WINLINE.VN STANDARD) -->
<!-- EXACT 100% FOOTER WINLINE.VN -->
<!-- EXACT 100% FOOTER WINLINE.VN WITH OFFICIAL SOCIAL & LEGAL LINKS -->
<!-- Footer -->
@endsection


