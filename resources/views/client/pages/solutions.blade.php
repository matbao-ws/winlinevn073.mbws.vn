@extends('client.layouts.app')

@section('title', 'Quạt cho nhà xưởng, kho bãi — chọn đúng lưu lượng khí | Winline.vn')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600&display=swap');
:root{
  --navy-950:#00354f; --navy-800:#004e7d; --navy-700:#1f6690; --navy-100:#e6eef3;
  --paper:#f7f8fa; --white:#ffffff; --ink:#1a2230; --ink-soft:#5c6773; --line:#dde3ea;
  --orange:#d41e3d; --orange-dark:#a71830; --orange-100:#f4e6e9; --green:#1e8a5f;
  --radius:6px; --shadow:0 2px 10px rgba(13,31,51,.08);
}
*{box-sizing:border-box;}
html,body{margin:0;padding:0;}
body{font-family:'Be Vietnam Pro',system-ui,sans-serif;color:var(--ink);background:var(--paper);font-size:15px;line-height:1.5;}
.mono{font-family:'IBM Plex Mono',monospace;}
a{color:inherit;text-decoration:none;}
img{max-width:100%;display:block;}
button{font-family:inherit;cursor:pointer;}






.logo{font-weight:800;font-size:24px;letter-spacing:.5px;color:var(--navy-950);display:flex;align-items:baseline;gap:2px;flex-shrink:0;}
.logo span{color:var(--orange);}














@media(max-width:960px){}

.breadcrumb{max-width:1320px;margin:0 auto;padding:14px 20px 0;font-size:12.5px;color:var(--ink-soft);}
.breadcrumb a:hover{color:var(--navy-800);text-decoration:underline;}

.page-head{max-width:1320px;margin:0 auto;padding:14px 20px 0;display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:10px;}
.page-head h1{font-size:22px;color:var(--navy-950);margin:0 0 4px;}
.page-head .count{font-size:12.5px;color:var(--ink-soft);}
.view-toggle{display:flex;border:1.5px solid var(--line);border-radius:8px;overflow:hidden;}
.view-toggle a{padding:8px 14px;font-size:12.5px;font-weight:600;color:var(--ink-soft);background:#fff;}
.view-toggle a.active{background:var(--navy-950);color:#fff;}

.listing{max-width:1320px;margin:0 auto;padding:18px 20px 60px;display:grid;grid-template-columns:230px 1fr;gap:22px;}
@media(max-width:880px){.listing{grid-template-columns:1fr;}}

.filters{background:#fff;border:1px solid var(--line);border-radius:9px;padding:16px;align-self:start;position:sticky;top:80px;}
@media(max-width:880px){.filters{position:static;}}
.filter-group{margin-bottom:16px;padding-bottom:14px;border-bottom:1px solid var(--line);}
.filter-group:last-child{border-bottom:none;margin-bottom:0;padding-bottom:0;}
.filter-title{font-size:12.5px;font-weight:700;color:var(--navy-950);margin-bottom:9px;}
.filter-opt{display:flex;align-items:center;gap:7px;font-size:12.5px;color:var(--ink);margin-bottom:8px;cursor:pointer;}
.filter-opt input{accent-color:var(--navy-800);width:14px;height:14px;flex-shrink:0;}
.filter-opt .fcount{margin-left:auto;color:#9aa7b4;font-size:11px;}
.filter-clear{font-size:11.5px;color:var(--navy-800);font-weight:700;text-decoration:underline;}

/* ---------- KHỐI GIỚI THIỆU LOẠI — đứng trên bảng, ảnh+tên bấm được ra category.html ---------- */
/* Đây là phần sửa lại theo đúng ảnh chụp bạn gửi: mỗi bảng thông số đi kèm
   1 khối giới thiệu loại sản phẩm ở trên — ảnh đại diện + tên loại (bấm được)
   + mô tả ngắn + 2 nút CTA. KHÁC với hiểu trước đó (click từng hàng trong
   bảng) — giờ click vào ẢNH/TÊN LOẠI mới là thứ dẫn ra category.html. */
.type-intro{max-width:1320px;margin:20px auto 0;padding:0 20px;}
.type-intro-inner{background:#fff;border:1px solid var(--line);border-radius:12px;padding:24px;display:grid;grid-template-columns:220px 1fr 220px;gap:26px;align-items:start;}
@media(max-width:900px){.type-intro-inner{grid-template-columns:1fr;}}
.type-img-link{display:block;border-radius:8px;overflow:hidden;border:1px dashed #c3ccd6;background:var(--paper);aspect-ratio:1/1;display:flex;align-items:center;justify-content:center;color:#9aa7b4;font-size:11px;text-align:center;}
.type-img-link:hover{border-color:var(--navy-700);}
.type-body h2{margin:0 0 8px;}
.type-body h2 a{font-size:19px;color:var(--navy-950);}
.type-body h2 a:hover{color:var(--navy-800);text-decoration:underline;}
.type-body p{margin:0;font-size:13px;color:var(--ink-soft);line-height:1.65;}
.type-cta{display:flex;flex-direction:column;gap:10px;}
.type-cta .btn{display:block;text-align:center;padding:13px 16px;border-radius:8px;font-weight:700;font-size:13.5px;}
.type-cta .btn-fill{background:var(--navy-800);color:#fff;}
.type-cta .btn-fill:hover{background:var(--navy-950);}
.type-cta .btn-outline{background:#fff;color:var(--navy-950);border:1.5px solid var(--line);}
.type-cta .btn-outline:hover{border-color:var(--navy-700);}
.type-cta .cms-flag{font-size:10.5px;color:#b3392c;text-align:center;line-height:1.4;}

/* ---------- BẢNG THÔNG SỐ — phần khác biệt chính so với category.html ---------- */
.table-scroll{background:#fff;border:1px solid var(--line);border-radius:10px;overflow-x:auto;}
.spec-table{width:100%;border-collapse:collapse;font-size:13px;min-width:920px;}
.spec-table thead th{
  background:var(--navy-100);color:var(--navy-950);font-weight:700;font-size:11.5px;
  text-transform:uppercase;letter-spacing:.02em;padding:12px 14px;text-align:left;
  white-space:nowrap;position:sticky;top:0;z-index:2;border-bottom:1px solid var(--line);
}
.spec-table thead th.num{text-align:right;}
.spec-table thead th .sort-ic{opacity:.5;font-size:10px;margin-left:3px;}
.spec-table tbody td{padding:11px 14px;border-bottom:1px solid var(--line);white-space:nowrap;vertical-align:middle;}
.spec-table tbody tr:last-child td{border-bottom:none;}
.spec-table tbody tr{cursor:pointer;}
.spec-table tbody tr:hover{background:var(--paper);}
.spec-table td.num{text-align:right;font-family:'IBM Plex Mono',monospace;}
.st-prod{display:flex;align-items:center;gap:10px;white-space:normal;min-width:220px;}
.st-thumb{width:38px;height:38px;border-radius:6px;background:var(--paper);border:1px dashed #c3ccd6;flex-shrink:0;}
.st-name{font-weight:600;color:var(--navy-950);font-size:13px;line-height:1.3;}
.st-sku{font-size:10.5px;color:var(--ink-soft);font-family:'IBM Plex Mono',monospace;}
.st-brand{color:var(--ink-soft);}
.st-price{font-weight:700;color:var(--navy-950);font-family:'IBM Plex Mono',monospace;}
.st-cta{font-size:11.5px;font-weight:700;color:var(--navy-800);}
.st-cta:hover{text-decoration:underline;}
.first-col-sticky{position:sticky;left:0;background:#fff;z-index:1;}
.spec-table thead th.first-col-sticky{z-index:3;}
.spec-table tbody tr:hover td.first-col-sticky{background:var(--paper);}

.table-note{max-width:1320px;margin:12px auto 0;padding:0 20px;font-size:11.5px;color:var(--ink-soft);}

.pagination{display:flex;justify-content:center;gap:6px;margin-top:24px;}
.pagination a{width:32px;height:32px;border:1px solid var(--line);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:12.5px;color:var(--ink-soft);background:#fff;}
.pagination a.active{background:var(--navy-950);color:#fff;border-color:var(--navy-950);}




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
<div class="breadcrumb"><a href="{{ route('client.home') }}">Trang chủ</a> › <a href="{{ route('client.solutions') }}">Giải pháp theo ngành</a> › Nhà xưởng — Kho bãi</div>

<div class="page-head">
  <div>
    <h1>Quạt cho nhà xưởng, kho bãi</h1>
    <div class="count">7 sản phẩm phù hợp — chọn theo đúng lưu lượng khí cần thiết, không đoán</div>
  </div>
</div>

<!-- ============ NỘI DUNG THỰC TẾ — khó khăn ngành + cách giải quyết, KHÔNG viết marketing ============ -->
<div class="type-intro" style="margin-top:14px;">
  <div class="type-intro-inner" style="grid-template-columns:1fr;">
    <div class="type-body">
      <p style="font-size:14px;color:var(--ink);margin-bottom:12px;">Nhà xưởng, kho bãi thường có trần cao, diện tích lớn, phát sinh nhiệt từ máy móc/hàng hoá — quạt công suất nhỏ không đủ lưu lượng khí, gây tích nhiệt, ảnh hưởng người lao động và chất lượng hàng lưu kho. Chọn sai lưu lượng (theo TCVN 5687:2010) là nguyên nhân phổ biến khiến lắp quạt rồi vẫn nóng.</p>
      <p style="font-size:14px;color:var(--ink);margin:0;">Nhóm quạt công nghiệp dưới đây đáp ứng lưu lượng lớn (8.000–28.000 m³/h), vận hành liên tục nhiều giờ, chịu được môi trường bụi. Dùng <a href="{{ route('client.calculator') }}" style="color:var(--navy-800);font-weight:700;">công cụ tính lưu lượng khí</a> theo đúng diện tích thực tế trước khi chọn model, tránh chọn thiếu hoặc thừa công suất gây lãng phí điện.</p>
    </div>
  </div>
</div>

<div class="listing" style="grid-template-columns:1fr;max-width:1320px;">
  <div class="results">
    <div class="table-scroll">
      <table class="spec-table">
        <thead>
          <tr>
            <th class="first-col-sticky">Sản phẩm <span class="sort-ic">↕</span></th>
            <th>Thương hiệu <span class="sort-ic">↕</span></th>
            <th class="num">Công suất <span class="sort-ic">↕</span></th>
            <th class="num">Lưu lượng gió <span class="sort-ic">↕</span></th>
            <th class="num">Sải cánh / Kích thước <span class="sort-ic">↕</span></th>
            <th>Điện áp</th>
            <th class="num">Số động cơ</th>
            <th class="num">Giá bán <span class="sort-ic">↕</span></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr onclick="location.href="{{ route('client.products') }}"">
            <td class="first-col-sticky"><div class="st-prod"><div class="st-thumb"></div><div><div class="st-name">Quạt cây công nghiệp Komasu KM-750S</div><div class="st-sku">SKU: KM-750S</div></div></div></td>
            <td class="st-brand">Komasu</td>
            <td class="num">250W</td>
            <td class="num">15.200–18.000 m³/h</td>
            <td class="num">Ø750mm</td>
            <td>220V/50Hz</td>
            <td class="num">1</td>
            <td class="num st-price">2.890.000đ</td>
            <td><a class="st-cta" href="{{ route('client.products') }}">Xem chi tiết →</a></td>
          </tr>
          <tr onclick="location.href="{{ route('client.products') }}"">
            <td class="first-col-sticky"><div class="st-prod"><div class="st-thumb"></div><div><div class="st-name">Quạt cây công nghiệp Vinawind VW-650S</div><div class="st-sku">SKU: VW-650S</div></div></div></td>
            <td class="st-brand">Vinawind</td>
            <td class="num">220W</td>
            <td class="num">11.000–13.500 m³/h</td>
            <td class="num">Ø650mm</td>
            <td>220V/50Hz</td>
            <td class="num">1</td>
            <td class="num st-price">2.150.000đ</td>
            <td><a class="st-cta" href="{{ route('client.products') }}">Xem chi tiết →</a></td>
          </tr>
          <tr onclick="location.href="{{ route('client.products') }}"">
            <td class="first-col-sticky"><div class="st-prod"><div class="st-thumb"></div><div><div class="st-name">Quạt cây công nghiệp Tico TC-800S</div><div class="st-sku">SKU: TC-800S</div></div></div></td>
            <td class="st-brand">Tico</td>
            <td class="num">280W</td>
            <td class="num">18.500–21.000 m³/h</td>
            <td class="num">Ø800mm</td>
            <td>220V/50Hz</td>
            <td class="num">1</td>
            <td class="num st-price">3.150.000đ</td>
            <td><a class="st-cta" href="{{ route('client.products') }}">Xem chi tiết →</a></td>
          </tr>
          <tr onclick="location.href="{{ route('client.products') }}"">
            <td class="first-col-sticky"><div class="st-prod"><div class="st-thumb"></div><div><div class="st-name">Quạt cây công nghiệp Hatari HT-550S</div><div class="st-sku">SKU: HT-550S</div></div></div></td>
            <td class="st-brand">Hatari</td>
            <td class="num">185W</td>
            <td class="num">9.800–11.200 m³/h</td>
            <td class="num">Ø550mm</td>
            <td>220V/50Hz</td>
            <td class="num">1</td>
            <td class="num st-price">1.920.000đ</td>
            <td><a class="st-cta" href="{{ route('client.products') }}">Xem chi tiết →</a></td>
          </tr>
          <tr onclick="location.href="{{ route('client.products') }}"">
            <td class="first-col-sticky"><div class="st-prod"><div class="st-thumb"></div><div><div class="st-name">Quạt cây công nghiệp Senko SK-700S</div><div class="st-sku">SKU: SK-700S</div></div></div></td>
            <td class="st-brand">Senko</td>
            <td class="num">240W</td>
            <td class="num">14.200–16.800 m³/h</td>
            <td class="num">Ø700mm</td>
            <td>220V/50Hz</td>
            <td class="num">1</td>
            <td class="num st-price">2.480.000đ</td>
            <td><a class="st-cta" href="{{ route('client.products') }}">Xem chi tiết →</a></td>
          </tr>
          <tr onclick="location.href="{{ route('client.products') }}"">
            <td class="first-col-sticky"><div class="st-prod"><div class="st-thumb"></div><div><div class="st-name">Quạt cây công nghiệp Komasu KM-1000S</div><div class="st-sku">SKU: KM-1000S</div></div></div></td>
            <td class="st-brand">Komasu</td>
            <td class="num">370W</td>
            <td class="num">24.500–28.000 m³/h</td>
            <td class="num">Ø1000mm</td>
            <td>220V/50Hz</td>
            <td class="num">1</td>
            <td class="num st-price">3.980.000đ</td>
            <td><a class="st-cta" href="{{ route('client.products') }}">Xem chi tiết →</a></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pagination">
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#">›</a>
    </div>
  </div>
</div>

<div class="table-note">Bảng có thể cuộn ngang trên màn hình nhỏ — cột "Sản phẩm" giữ cố định bên trái để dễ đối chiếu khi cuộn.</div>

<!-- UNIVERSAL MASTER FOOTER (COMPACT & MODERN - WINLINE.VN STANDARD) -->
<!-- EXACT 100% FOOTER WINLINE.VN -->
<!-- EXACT 100% FOOTER WINLINE.VN WITH OFFICIAL SOCIAL & LEGAL LINKS -->

<!-- ================= KHỐI MÔ TẢ & GIẢI PHÁP KỸ THUẬT ================= -->
<div class="category-desc-wrap">
  <article class="category-desc-box">
    <header class="cdb-header">
      <i class="fas fa-layer-group"></i>
      <h2>Tổng Quan Giải Pháp Thông Gió &amp; Làm Mát Không Khí Nhà Xưởng Chuẩn TCVN 5687:2010</h2>
    </header>

    <div class="cdb-body">
      <p>
        Trong các nhà xưởng sản xuất cơ khí, dệt may, bao bì, chế biến gỗ hay kho chứa hàng logistics, nhiệt lượng sinh ra từ máy móc hoạt động liên tục kết hợp mật độ công nhân cao thường đẩy nhiệt độ bên trong lên <strong>38°C – 42°C</strong>. Việc đầu tư hệ thống điều hòa không khí truyền thống tốn kém chi phí ban đầu rất lớn và chi phí tiền điện khổng lồ hàng tháng. <strong>Winline Việt Nam</strong> mang đến các giải pháp thông gió làm mát công nghiệp tối ưu với chi phí đầu tư chỉ bằng 1/3 và tiết kiệm tới 80% điện năng tiêu thụ.
      </p>

      <div class="cdb-grid-cards">
        <div class="cdb-card-item">
          <h4><i class="fas fa-temperature-arrow-down"></i> Hệ Thống Áp Suất Âm (Cooling Pad)</h4>
          <p>Kết hợp quạt hút vuông composite/inox hút gió nóng ra ngoài và dàn tấm làm mát Cooling Pad cấp khí tươi hạ 5°C – 10°C, độ ẩm cân bằng.</p>
        </div>
        <div class="cdb-card-item">
          <h4><i class="fas fa-arrows-to-circle"></i> Hệ Thống Áp Suất Dương (Air Cooler)</h4>
          <p>Máy làm mát công nghiệp thổi trực tiếp luồng khí mát vào các vị trí công nhân làm việc qua hệ thống ống gió tôn mạ kẽm và miệng gió khuếch tán.</p>
        </div>
        <div class="cdb-card-item">
          <h4><i class="fas fa-smog"></i> Hút Khói &amp; Thông Gió Sự Cố PCCC</h4>
          <p>Quạt ly tâm và quạt hướng trục công suất lớn hút khói tầng hầm, tăng áp buồng thang thoát hiểm, vận hành ổn định trong điều kiện nhiệt độ cao.</p>
        </div>
        <div class="cdb-card-item">
          <h4><i class="fas fa-filter"></i> Xử Lý Bụi &amp; Hút Khí Thải Công Nghiệp</h4>
          <p>Hệ thống lọc bụi túi vải cyclone, hút bụi chà nhám gỗ, bụi mài kim loại và hệ thống tháp hấp phụ than hoạt tính khử mùi sơn, dung môi.</p>
        </div>
      </div>

      <div class="cdb-collapse-content" id="gp-more-desc">
        <h3><i class="fas fa-clipboard-list"></i> Quy Trình Khảo Sát &amp; Thi Công Của Winline</h3>
        <ul>
          <li><strong>Bước 1: Khảo sát hiện trạng &amp; đo đạc vi khí hậu:</strong> Đội ngũ kỹ sư HVAC trực tiếp đến nhà xưởng đo nhiệt độ, độ ẩm, hướng gió tự nhiên và nguồn nhiệt phát sinh.</li>
          <li><strong>Bước 2: Tính toán lưu lượng &amp; thiết kế bản vẽ:</strong> Sử dụng <a href="{{ route('client.calculator') }}" style="color:var(--brand-blue);font-weight:700;">Công cụ tính toán chuẩn TCVN 5687:2010</a> để xác định chính xác số lượng quạt, diện tích tấm Cooling Pad và công suất máy.</li>
          <li><strong>Bước 3: Lập bảng dự toán &amp; hồ sơ năng lực:</strong> Báo giá chi tiết theo từng hạng mục vật tư, xuất trình giấy chứng nhận xuất xứ CO/CQ của thiết bị.</li>
          <li><strong>Bước 4: Thi công, nghiệm thu &amp; chuyển giao công nghệ:</strong> Thi công nhanh chóng theo đúng tiến độ, bàn giao biên bản nghiệm thu và hướng dẫn vận hành an toàn.</li>
        </ul>

        <div class="cdb-highlight-box">
          <strong><i class="fas fa-phone-volume"></i> Tư vấn kỹ thuật miễn phí:</strong> Quý chủ đầu tư và nhà thầu cơ điện cần khảo sát mặt bằng hoặc nhận bản vẽ thiết kế giải pháp vui lòng liên hệ Hotline <strong>0949.761.893</strong> hoặc gửi yêu cầu về email <strong>winlinevietnam@gmail.com</strong>.
        </div>
      </div>

      <div class="cdb-toggle-wrap">
        <button type="button" class="cdb-toggle-btn" onclick="toggleCategoryDesc('gp-more-desc', this)">
          <span>Xem thêm quy trình &amp; tiêu chuẩn kỹ thuật</span> <i class="fas fa-chevron-down"></i>
        </button>
      </div>
    </div>
  </article>
</div>

<!-- Footer -->
@endsection

@push('scripts')
<script>
>
function toggleCategoryDesc(id, btn) {
  const content = document.getElementById(id);
  if (!content) return;
  const isOpen = content.classList.contains('open');
  if (isOpen) {
    content.classList.remove('open');
    btn.querySelector('span').textContent = btn.getAttribute('data-text-more') || 'Xem thêm';
    btn.querySelector('i').className = 'fas fa-chevron-down';
  } else {
    content.classList.add('open');
    if (!btn.getAttribute('data-text-more')) {
      btn.setAttribute('data-text-more', btn.querySelector('span').textContent);
    }
    btn.querySelector('span').textContent = 'Thu gọn nội dung';
    btn.querySelector('i').className = 'fas fa-chevron-up';
  }
}
</script>
@endpush

