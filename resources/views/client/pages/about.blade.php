@extends('client.layouts.app')

@section('title', 'Về Winline — Công ty TNHH Winline Việt Nam | Quạt điện, quạt công nghiệp')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600&display=swap');

:root{
  --navy-950:#004e7d;
  --navy-800:#004e7d;
  --navy-700:#1f6690;
  --navy-100:#e6eef3;
  --paper:#f7f8fa;
  --white:#ffffff;
  --ink:#1a2230;
  --ink-soft:#5c6773;
  --line:#dde3ea;
  --orange:#d41e3d;
  --orange-dark:#a71830;
  --orange-100:#f4e6e9;
  --green:#1e8a5f;
  --radius:6px;
  --shadow:0 2px 10px rgba(13,31,51,.08);
}
*{box-sizing:border-box;}
html,body{margin:0;padding:0;overflow-x:hidden;max-width:100%;}
body{
  font-family:'Be Vietnam Pro',system-ui,sans-serif;
  color:var(--ink);
  background:var(--paper);
  font-size:15px;
  line-height:1.5;
}
.mono{font-family:'IBM Plex Mono',monospace;}
a{color:inherit;text-decoration:none;}
img{max-width:100%;display:block;}
button{font-family:inherit;cursor:pointer;}

/* ---------- utility bar ---------- */













/* ---------- breadcrumb ---------- */
.breadcrumb{max-width:1240px;margin:0 auto;padding:14px 20px 0;font-size:12.5px;color:var(--ink-soft);}
.breadcrumb a:hover{color:var(--navy-800);text-decoration:underline;}

/* ---------- hero section ---------- */
.hero-section{
  max-width:1240px;margin:0 auto;padding:40px 20px 50px;
  text-align:center;
}
.hero-section h1{
  font-size:42px;font-weight:800;color:var(--navy-950);
  margin:0 0 14px;line-height:1.2;
}
.hero-section .hero-sub{
  font-size:18px;color:var(--ink-soft);margin:0 0 20px;
  max-width:720px;margin-left:auto;margin-right:auto;line-height:1.6;
}

/* ---------- intro card ---------- */
.intro-card{
  max-width:1240px;margin:0 auto;padding:0 20px 40px;
}
.intro-content{
  background:#fff;border:1px solid var(--line);border-radius:12px;
  box-shadow:var(--shadow);padding:32px 40px;line-height:1.8;
  font-size:15.5px;
}
.intro-content p{margin:0 0 18px;}
.intro-content p:last-child{margin:0;}
.intro-content b{color:var(--navy-950);font-weight:700;}

/* ---------- stats grid ---------- */
.stats-band{
  background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line);
  padding:36px 0;
}
.stats-inner{
  max-width:1240px;margin:0 auto;padding:0 20px;
  display:grid;grid-template-columns:repeat(4,1fr);gap:20px;
}
@media(max-width:960px){.stats-inner{grid-template-columns:repeat(2,1fr);}}
@media(max-width:640px){.stats-inner{grid-template-columns:1fr;}}
.stat-card{text-align:center;padding:12px 0;}
.stat-number{
  font-size:36px;font-weight:800;color:var(--navy-800);
  font-family:'IBM Plex Mono',monospace;margin-bottom:6px;
}
.stat-label{
  font-size:13px;color:var(--ink-soft);font-weight:600;
  text-transform:uppercase;letter-spacing:.04em;
}

/* ---------- timeline ---------- */
.timeline-section{
  max-width:1240px;margin:40px auto 0;padding:0 20px 50px;
}
.timeline-section h2{
  font-size:28px;font-weight:700;color:var(--navy-950);
  margin:0 0 6px;
}
.timeline-sub{
  font-size:14px;color:var(--ink-soft);margin:0 0 30px;
}
.timeline-container{
  position:relative;padding-left:16px;
}
.timeline-item{
  position:relative;padding-bottom:32px;padding-left:28px;border-left:2px solid var(--navy-100);
}
.timeline-item:last-child{border-left-color:transparent;}
.timeline-item::before{
  content:'';position:absolute;left:-7px;top:4px;
  width:12px;height:12px;border-radius:50%;background:var(--navy-800);
  border:2px solid #fff;box-shadow:0 0 0 2px var(--navy-100);
}
.timeline-date{
  font-size:13px;font-weight:700;color:var(--navy-800);
  font-family:'IBM Plex Mono',monospace;margin-bottom:6px;
}
.timeline-title{
  font-size:16px;font-weight:700;color:var(--navy-950);
  margin-bottom:6px;
}
.timeline-desc{
  font-size:14px;color:var(--ink-soft);line-height:1.6;
}

/* ---------- commit band ---------- */
.commit-band{
  background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line);
  padding:36px 0;margin-top:40px;
}
.commit-inner{
  max-width:1240px;margin:0 auto;padding:0 20px;
  display:grid;grid-template-columns:repeat(4,1fr);gap:18px;
}
@media(max-width:760px){.commit-inner{grid-template-columns:repeat(2,1fr);}}
.commit-item{display:flex;align-items:flex-start;gap:12px;}
.commit-item .c-icon{
  width:42px;height:42px;border-radius:50%;background:var(--navy-100);color:var(--navy-800);
  display:flex;align-items:center;justify-content:center;font-size:19px;flex-shrink:0;
}
.commit-item .c-text{font-size:13px;color:var(--navy-950);font-weight:600;line-height:1.4;}
.commit-item .c-text span{display:block;font-weight:400;color:var(--ink-soft);font-size:11.5px;margin-top:2px;}

/* ---------- team section ---------- */
.team-section{
  max-width:1240px;margin:40px auto 0;padding:0 20px 50px;
}
.team-section h2{
  font-size:28px;font-weight:700;color:var(--navy-950);
  margin:0 0 30px;
}
.team-grid{
  display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px;
}
.team-card{
  background:#fff;border:1px solid var(--line);border-radius:10px;
  padding:24px 20px;text-align:center;
}
.team-avatar{
  width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--navy-800),var(--navy-700));
  color:#fff;display:flex;align-items:center;justify-content:center;
  font-size:32px;font-weight:700;margin:0 auto 16px;
}
.team-name{
  font-size:15px;font-weight:700;color:var(--navy-950);margin-bottom:4px;
}
.team-role{
  font-size:12.5px;color:var(--ink-soft);font-weight:500;
  text-transform:uppercase;letter-spacing:.02em;margin-bottom:12px;
}
.team-contact{
  font-size:11.5px;color:var(--ink-soft);line-height:1.6;
}

/* ---------- contact section ---------- */
.contact-section{
  max-width:1240px;margin:40px auto 0;padding:0 20px 60px;
}
.contact-section h2{
  font-size:28px;font-weight:700;color:var(--navy-950);
  margin:0 0 30px;
}
.contact-grid{
  display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;
}
.contact-card{
  background:#fff;border:1px solid var(--line);border-radius:10px;
  padding:26px 28px;
}
.contact-card .cc-icon{
  font-size:32px;margin-bottom:12px;
}
.contact-card h3{
  font-size:15px;font-weight:700;color:var(--navy-950);
  margin:0 0 8px;
}
.contact-card p{
  font-size:13.5px;color:var(--ink-soft);margin:0 0 12px;line-height:1.6;
}
.contact-card .cc-value{
  font-size:14px;font-weight:700;color:var(--navy-800);
  font-family:'IBM Plex Mono',monospace;
}

/* ---------- cta section ---------- */
.cta-section{
  max-width:1240px;margin:40px auto;padding:0 20px;
  background:var(--navy-100);border-radius:12px;padding:40px;
  text-align:center;
}
.cta-section h3{
  font-size:24px;font-weight:700;color:var(--navy-950);
  margin:0 0 12px;
}
.cta-section p{
  font-size:15px;color:var(--ink-soft);margin:0 0 24px;
  max-width:640px;margin-left:auto;margin-right:auto;
}
.btn-cta{
  display:inline-block;background:var(--navy-800);color:#fff;
  border:none;padding:14px 32px;border-radius:8px;
  font-weight:700;font-size:14.5px;text-decoration:none;
  font-family:inherit;cursor:pointer;
}
.btn-cta:hover{background:var(--navy-950);}

/* ---------- 
.
.
.


/* ---------- float contact ---------- */
.float-contact{
  position:fixed;right:22px;bottom:90px;display:flex;flex-direction:column;gap:10px;z-index:45;
}
@media(max-width:640px){.float-contact{display:none;}}
.float-contact a{
  width:50px;height:50px;border-radius:50%;display:flex;align-items:center;justify-content:center;
  color:#fff;box-shadow:0 3px 10px rgba(0,0,0,.2);
}
.float-contact .fc-zalo{background:#0068ff;}
.float-contact .fc-call{background:var(--green);}

/* ---------- mobile sticky bar ---------- */
.mobile-sticky{
  display:none;position:fixed;bottom:0;left:0;right:0;background:#fff;
  border-top:1px solid var(--line);box-shadow:0 -6px 20px rgba(13,31,51,.10);
  padding:9px 10px calc(9px + env(safe-area-inset-bottom));z-index:50;
  justify-content:space-around;align-items:flex-start;
}
.msb-icon{display:flex;flex-direction:column;align-items:center;gap:3px;text-decoration:none;flex:1;background:none;border:none;font-family:inherit;}
.msb-circle{
  width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;
  color:#fff;box-shadow:0 2px 7px rgba(0,0,0,.14);
}
.msb-icon.zalo .msb-circle{background:#0068ff;}
.msb-icon.call .msb-circle{background:var(--green);}
.msb-label{font-size:10px;font-weight:700;color:var(--ink-soft);}
@media(max-width:640px){
  .mobile-sticky{display:flex;}
  body{padding-bottom:80px;}
}


/* ==========================================================================
   ENHANCED RESPONSIVE & UX/UI ADDITIONS
   ========================================================================== */

/* Logo styling */



/* Mobile Nav Toggle Button */
.nav-toggle-btn {
  display: none;
  background: none;
  border: 1px solid var(--line);
  border-radius: var(--radius);
  color: var(--ink);
  font-size: 20px;
  padding: 6px 12px;
  cursor: pointer;
}

/* Mobile Bottom Floating Bar */
.mobile-floating-bar {
  display: none;
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: #ffffff;
  border-top: 1px solid var(--line);
  box-shadow: 0 -4px 15px rgba(0,0,0,0.08);
  z-index: 999;
  padding: 8px 12px;
}
.mobile-floating-inner {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 8px;
  text-align: center;
  max-width: 500px;
  margin: 0 auto;
}
.mobile-action-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  font-size: 11px;
  font-weight: 600;
  color: var(--ink);
  text-decoration: none;
  gap: 3px;
}
.mobile-action-item .m-icon {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  color: #fff;
}
.m-icon.call { background: var(--orange); }
.m-icon.zalo { background: #0068ff; }
.m-icon.calc { background: #eab308; }
.m-icon.home { background: var(--navy-800); }

/* Responsive Media Queries */
@media (max-width: 900px) {
  .nav-toggle-btn {
    display: block;
  }
  .catnav {
    display: none;
  }
  .catnav.show-mobile {
    display: block;
    background: var(--navy-950);
  }
  .listing {
    grid-template-columns: 1fr !important;
  }
  .mobile-filter-btn {
    display: block !important;
    width: 100%;
    background: #fff;
    border: 1px solid var(--line);
    border-radius: var(--radius);
    padding: 10px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 15px;
    cursor: pointer;
  }
  .filters {
    display: none;
  }
  .filters.show-mobile-filter {
    display: block !important;
    margin-bottom: 20px;
  }

  .mobile-floating-bar {
    display: block;
  }
  body {
    padding-bottom: 60px;
  }
}
</style>
@endpush

@section('content')
<div class="breadcrumb">
  <a href="#">Trang chủ</a> › Về Winline
</div>

<div class="hero-section">
  <h1>Về Winline</h1>
  <p class="hero-sub">Hơn một thập kỷ kinh doanh quạt điện, quạt công nghiệp — từ khách lẻ đến công trình lớn, Winline là đối tác tin cậy của hàng nghìn khách hàng trên toàn quốc.</p>
</div>

<div class="intro-card">
  <div class="intro-content">
    <p><b>Công ty TNHH Winline Việt Nam</b> thành lập năm 2013, tiền thân là một cửa hàng bán quạt điện thủ công từ năm 1990. Chúng tôi chuyên cung cấp quạt điện dân dụng và quạt công nghiệp cho khách hàng cá nhân, khách sạn, nhà hàng, bệnh viện, trường học, nhà xưởng, kho bãi và các công trình xây dựng.</p>
    <p>Mô hình kinh doanh của Winline hoạt động theo hướng <b>bán lẻ và bán cho công trình/doanh nghiệp qua website và Zalo/điện thoại</b>. Chúng tôi không ôm tồn kho lớn, mà thay vào đó duy trì quan hệ ổn định với 6 nhà phân phối chính tại Hà Nội, lấy hàng theo yêu cầu từ khách. Cách làm này giúp Winline cung cấp giá cạnh tranh, không tốn chi phí bảo quản, và <b>luôn có sản phẩm mới nhất để phục vụ khách</b>.</p>
    <p>Hiện tại, Winline phục vụ <b>hàng nghìn khách hàng</b> với mô hình <b>bán hàng ổn định từ doanh thu B2B</b> (công trình, kho-xưởng, nhà hàng, bệnh viện) — nhóm khách này có tỷ lệ quay lại cao nhất, và là nguồn doanh thu chính.</p>
  </div>
</div>

<div class="stats-band">
  <div class="stats-inner">
    <div class="stat-card">
      <div class="stat-number">15+</div>
      <div class="stat-label">Năm kinh doanh</div>
    </div>
    <div class="stat-card">
      <div class="stat-number">&lt;10</div>
      <div class="stat-label">Nhân viên tận tâm</div>
    </div>
    <div class="stat-card">
      <div class="stat-number">Hàng nghìn</div>
      <div class="stat-label">Khách hàng phục vụ</div>
    </div>
    <div class="stat-card">
      <div class="stat-number">6+</div>
      <div class="stat-label">Nhà phân phối chính</div>
    </div>
  </div>
</div>

<div class="timeline-section">
  <h2>Quá trình phát triển</h2>
  <p class="timeline-sub">Từ cửa hàng nhỏ đến đối tác tin cậy của hàng nghìn khách hàng</p>
  <div class="timeline-container">

    <div class="timeline-item">
      <div class="timeline-date">1990</div>
      <div class="timeline-title">Khởi đầu — Cửa hàng bán quạt điện thủ công</div>
      <div class="timeline-desc">Tiền thân của Winline — một cửa hàng nhỏ bán quạt điện tại Hà Nội, phục vụ khách lẻ và nhỏ lẻ với thái độ tận tâm.</div>
    </div>

    <div class="timeline-item">
      <div class="timeline-date">15/01/2013</div>
      <div class="timeline-title">Thành lập Công ty TNHH Winline Việt Nam</div>
      <div class="timeline-desc">Chính thức đăng ký kinh doanh với MST 0106085370. Mở rộng đội ngũ, phát triển danh mục sản phẩm, bắt đầu phục vụ khách hàng B2B (công trình, kho-xưởng).</div>
    </div>

    <div class="timeline-item">
      <div class="timeline-date">01/07/2014</div>
      <div class="timeline-title">Mở chi nhánh Xã Đàn</div>
      <div class="timeline-desc">Mở cửa hàng chi nhánh tại số 246 phố Xã Đàn, Hà Nội — đánh dấu bước mở rộng địa lý phục vụ khách hàng.</div>
    </div>

    <div class="timeline-item">
      <div class="timeline-date">23/07/2019</div>
      <div class="timeline-title">Chuyển kho sang Quan Nhân</div>
      <div class="timeline-desc">Chuyển cửa hàng/kho sang số 17 ngõ 46 phố Quan Nhân, Thanh Xuân, Hà Nội — vị trí tập trung hơn, có kho riêng, phục vụ tốt hơn khách hàng đến trực tiếp.</div>
    </div>

    <div class="timeline-item">
      <div class="timeline-date">2024</div>
      <div class="timeline-title">Hiện tại — Phát triển bền vững</div>
      <div class="timeline-desc">Hiện nay Winline phục vụ hàng nghìn khách hàng, duy trì doanh thu ổn định từ khách B2B ổn định. Tiếp tục nâng cao dịch vụ và mở rộng danh mục sản phẩm.</div>
    </div>

  </div>
</div>

<div class="commit-band">
  <div class="commit-inner">
    <div class="commit-item">
      <div class="c-icon"><i class="fas fa-truck-fast"></i></div>
      <div class="c-text">Giao đúng hạn<span>98–99% đơn hàng</span></div>
    </div>
    <div class="commit-item">
      <div class="c-icon"><i class="fas fa-shield-halved"></i></div>
      <div class="c-text">Bảo hành uy tín<span>12 tháng — hư gì đổi nấy</span></div>
    </div>
    <div class="commit-item">
      <div class="c-icon"><i class="fas fa-rotate-left"></i></div>
      <div class="c-text">Đổi trả dễ dàng<span>Miễn phí trong 30 ngày</span></div>
    </div>
    <div class="commit-item">
      <div class="c-icon"><i class="fas fa-headset"></i></div>
      <div class="c-text">Tư vấn tận tâm<span>Nhân viên hỗ trợ 24/7</span></div>
    </div>
  </div>
</div>

<div class="team-section">
  <h2>Đội ngũ Winline</h2>
  <div class="team-grid">
    <div class="team-card">
      <div class="team-avatar"><i class="fas fa-user-tie"></i></div>
      <div class="team-name">Founder & Quản lý</div>
      <div class="team-role">Quản lý điều hành</div>
      <div class="team-contact">Hơn 30 năm kinh doanh quạt điện<br>Trực tiếp tư vấn các đơn lớn</div>
    </div>
    <div class="team-card">
      <div class="team-avatar"><i class="fas fa-user-check"></i></div>
      <div class="team-name">Nhân viên tư vấn 1</div>
      <div class="team-role">Sales & Support</div>
      <div class="team-contact">Hỗ trợ khách B2B<br>Giải đáp thông số, báo giá</div>
    </div>
    <div class="team-card">
      <div class="team-avatar"><i class="fas fa-user-gear"></i></div>
      <div class="team-name">Nhân viên tư vấn 2</div>
      <div class="team-role">Sales & Support</div>
      <div class="team-contact">Hỗ trợ khách lẻ & thương mại<br>Quản lý đơn hàng, giao nhận</div>
    </div>
  </div>
</div>

<div class="contact-section">
  <h2>Thông tin liên hệ</h2>
  <div class="contact-grid">
    <div class="contact-card">
      <div class="cc-icon">🏢</div>
      <h3>Văn phòng &amp; Kho</h3>
      <p>Số 17 ngõ 46 phố Quan Nhân<br>Phường Thanh Xuân, Hà Nội</p>
      <a href="https://maps.google.com/?q=17+ngo+46+pho+Quan+Nhan+Ha+Noi" target="_blank" style="color:var(--navy-800);font-weight:700;text-decoration:underline;">Xem trên bản đồ →</a>
    </div>
    <div class="contact-card">
      <div class="cc-icon">☎️</div>
      <h3>Điện thoại</h3>
      <p>Hotline liên hệ</p>
      <div class="cc-value"><a href="tel:0949761893">0949 761 893</a></div>
    </div>
    <div class="contact-card">
      <div class="cc-icon">💬</div>
      <h3>Chat Zalo</h3>
      <p>Hỗ trợ nhanh, tư vấn miễn phí</p>
      <div class="cc-value"><a href="#" style="color:var(--navy-800);font-weight:700;text-decoration:underline;">Mở Zalo OA →</a></div>
    </div>
    <div class="contact-card">
      <div class="cc-icon">✉️</div>
      <h3>Email</h3>
      <p>Gửi yêu cầu, hỏi đáp</p>
      <div class="cc-value"><a href="mailto:contact@winline.vn">contact@winline.vn</a></div>
    </div>
  </div>
</div>

<div class="cta-section">
  <h3>Sẵn sàng làm việc với chúng tôi?</h3>
  <p>Liên hệ ngay để nhận báo giá, tư vấn sản phẩm phù hợp, hoặc thảo luận các yêu cầu đặc biệt cho công trình của bạn.</p>
  <button class="btn-cta" onclick="openContact()">Liên hệ Winline ngay</button>
</div>

<!-- UNIVERSAL MASTER FOOTER (COMPACT & MODERN - WINLINE.VN STANDARD) -->
<!-- EXACT 100% FOOTER WINLINE.VN -->
<!-- EXACT 100% FOOTER WINLINE.VN WITH OFFICIAL SOCIAL & LEGAL LINKS -->
<!-- Footer -->
@endsection


