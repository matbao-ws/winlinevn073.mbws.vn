@extends('client.layouts.app')

@section('title', '+ <meta name="description">
  2. Breadcrumb — tên hãng ở cuối
  3. H1 + dòng đếm số sản phẩm
  4. Khối .brand-strip — tên hãng, dòng mô tả 1 câu (data-cms-field, cần Winline
     xác nhận đúng quan hệ phân phối thật trước khi lên, KHÔNG tự suy đoán)
  5. Trạng thái "active" trong dropdown "Thương hiệu ▾" ở nav
  6. Bộ lọc "Loại quạt" — tick sẵn đúng loại hãng đó có bán (không tick loại hãng
     không có, tránh trang lọc ra 0 kết quả)
  7. Lưới sản phẩm — đổi thành đúng SKU thật của hãng đó (ở bản mẫu này vẫn còn
     record cũ "<img src="assets/images/km750s.jpg" alt="Quạt" style="max-height:140px; max-width:100%; object-fit:contain; margin:auto;">" placeholder, sẽ thay khi có ảnh chụp thật)

  KHÔNG ĐỔI khi nhân bản: toàn bộ CSS, cấu trúc header/nav/footer, logic JS,
  layout sidebar+grid, breakpoint responsive — y hệt category.html để đảm bảo
  đồng bộ toàn site.

  GHI CHÚ MÀU: file này đã cập nhật theo đúng hệ màu mới nhất đang dùng ở
  chi-tiet-san-pham.html (--navy-950:#00354f, --orange:#d41e3d) — category.html
  và homepage.html hiện TẠI VẪN dùng bảng màu cũ (#0d1f33 / #e2600f), nên khi
  đồng bộ lại toàn site, 2 file đó cũng cần cập nhật theo hệ màu này, không
  phải riêng file này lệch chuẩn.
  ===========================================================================
-->

<!-- [BRAND: title/meta] -->
<title>Quạt Vinawind chính hãng — giá tốt nhất hệ thống Winline | Winline.vn')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600&display=swap');

:root{
  /* Đồng bộ đúng hệ màu mới nhất từ chi-tiet-san-pham.html (v11) — 1 hue xanh
     #004e7d, 1 mã đỏ #d41e3d duy nhất, không dùng lại bảng màu cũ của
     category.html/homepage.html. */
  --navy-950:#00354f;
  --navy-800:#004e7d;
  --navy-700:#1f6690;
  --navy-100:#e6eef3;
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

/* ---------- utility / header / nav (đồng bộ toàn site) ---------- */


 




.logo{font-weight:800;font-size:24px;letter-spacing:.5px;color:var(--navy-950);display:flex;align-items:baseline;gap:2px;flex-shrink:0;}
.logo span{color:var(--orange);}


















@media(max-width:960px){}

.breadcrumb{max-width:1240px;margin:0 auto;padding:14px 20px 0;font-size:12.5px;color:var(--ink-soft);}
.breadcrumb a:hover{color:var(--navy-800);text-decoration:underline;}

.page-head{max-width:1240px;margin:0 auto;padding:14px 20px 0;display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:10px;}
.page-head h1{font-size:22px;color:var(--navy-950);margin:0 0 4px;}
.page-head .count{font-size:12.5px;color:var(--ink-soft);}
.sort-wrap{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--ink-soft);}
.sort-wrap select{padding:8px 10px;border:1.5px solid var(--line);border-radius:5px;font-family:inherit;font-size:13px;color:var(--navy-950);background:#fff;}

/* ---------- KHỐI RIÊNG CHO TRANG THƯƠNG HIỆU — brand-strip ---------- */
/* Cố tình làm 1 dải NGẮN, KHÔNG phải section bài viết dài — đúng quyết định
   "không đầu tư bài biên tập" nhưng vẫn cho khách 1 dòng thông tin xác nhận
   quan hệ phân phối + logo, tránh trang trông như category.html lọc sẵn
   không rõ vì sao có brand đó. */
.brand-strip{max-width:1240px;margin:14px auto 0;padding:0 20px;}
.brand-strip-inner{
  background:#fff;border:1px solid var(--line);border-radius:10px;
  padding:16px 20px;display:flex;align-items:center;gap:18px;flex-wrap:wrap;
}
.brand-logo-box{
  width:64px;height:64px;border-radius:8px;background:var(--paper);border:1px dashed #c3ccd6;
  display:flex;align-items:center;justify-content:center;color:#9aa7b4;font-size:10px;
  text-align:center;flex-shrink:0;line-height:1.3;
}
.brand-strip-text{flex:1;min-width:220px;}
.brand-strip-text p{margin:0;font-size:13.5px;color:var(--ink);line-height:1.55;}
.brand-strip-text .cms-flag{font-size:10.5px;color:#b3392c;margin-top:4px;display:block;}
.brand-facts{display:flex;gap:8px;flex-wrap:wrap;flex-shrink:0;}
.brand-fact{
  background:var(--navy-100);color:var(--navy-800);font-size:11.5px;font-weight:700;
  padding:6px 11px;border-radius:20px;white-space:nowrap;
}

/* ---------- layout: sidebar lọc + lưới sản phẩm ---------- */
.listing{max-width:1240px;margin:0 auto;padding:18px 20px 60px;display:grid;grid-template-columns:250px 1fr;gap:26px;}
@media(max-width:880px){.listing{grid-template-columns:1fr;}}

.filters{background:#fff;border:1px solid var(--line);border-radius:9px;padding:18px;align-self:start;position:sticky;top:80px;}
@media(max-width:880px){.filters{position:static;}}
.filter-group{margin-bottom:20px;padding-bottom:18px;border-bottom:1px solid var(--line);}
.filter-group:last-child{border-bottom:none;margin-bottom:0;padding-bottom:0;}
.filter-title{font-size:13px;font-weight:700;color:var(--navy-950);margin-bottom:11px;}
.filter-opt{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--ink);margin-bottom:9px;cursor:pointer;}
.filter-opt input{accent-color:var(--navy-800);width:15px;height:15px;flex-shrink:0;}
.filter-opt .fcount{margin-left:auto;color:#9aa7b4;font-size:11.5px;}
.price-presets{display:flex;flex-direction:column;gap:8px;}
.price-chip{border:1.5px solid var(--line);border-radius:6px;padding:8px 10px;font-size:12.5px;text-align:left;background:#fff;color:var(--ink);}
.price-chip.active{border-color:var(--orange);background:var(--orange-100);color:var(--orange-dark);font-weight:700;}
.filter-clear{font-size:12px;color:var(--navy-800);font-weight:700;text-decoration:underline;}

/* ---------- product grid + card ---------- */
.prod-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(228px,1fr));gap:16px;}
.prod-card{background:#fff;border:1px solid var(--line);border-radius:9px;overflow:hidden;position:relative;}
.prod-card .p-img{aspect-ratio:1/1;background:var(--paper);display:flex;align-items:center;justify-content:center;color:#9aa7b4;font-size:11px;text-align:center;padding:10px;position:relative;}
.prod-card .p-badge{position:absolute;top:9px;left:9px;background:var(--navy-950);color:#fff;font-size:10px;font-weight:700;padding:3px 8px;border-radius:3px;}
.prod-card .p-badge.low{background:var(--orange);}
.prod-card .p-body{padding:12px 13px 13px;}
/* Lưu ý: bỏ hẳn dòng .p-brand (tên hãng) trong card so với category.html —
   trên trang thương hiệu, mọi sản phẩm đều cùng 1 hãng nên nhắc lại là thừa,
   thay vào đó dùng đúng khoảng trống đó cho tên dòng sản phẩm rõ hơn. */
.prod-card .p-name{font-size:13.5px;font-weight:600;color:var(--navy-950);line-height:1.35;min-height:37px;margin-bottom:6px;}
.prod-card .p-specs{list-style:none;margin:0 0 8px;padding:0;font-size:11px;color:var(--ink-soft);line-height:1.6;}
.prod-card .p-specs li::before{content:"• ";color:var(--orange);}
.prod-card .p-price{font-weight:700;color:var(--navy-950);font-family:'IBM Plex Mono',monospace;font-size:15.5px;}
.prod-card .p-bulk{font-size:10.5px;color:var(--navy-800);margin-top:3px;}
.prod-card .p-rating{display:flex;align-items:center;gap:5px;font-size:11px;color:var(--orange);margin-top:6px;}
.prod-card .p-rating span{color:var(--ink-soft);}
.prod-card .p-stock{font-size:10.5px;color:var(--green);font-weight:600;margin-top:6px;display:flex;align-items:center;gap:4px;}
.prod-card .p-stock.out{color:#b3392c;}
.prod-card .p-stock .d{width:5px;height:5px;border-radius:50%;background:var(--green);}
.prod-card .p-stock.out .d{background:#b3392c;}

.pagination{display:flex;justify-content:center;gap:6px;margin-top:30px;}
.pagination a{width:34px;height:34px;border:1px solid var(--line);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:13px;color:var(--ink-soft);background:#fff;}
.pagination a.active{background:var(--navy-950);color:#fff;border-color:var(--navy-950);}

/* ---------- 
.msb-icon{display:flex;flex-direction:column;align-items:center;gap:3px;text-decoration:none;flex:1;background:none;border:none;font-family:inherit;}
.msb-circle{width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;box-shadow:0 2px 7px rgba(0,0,0,.14);}
.msb-icon.menu .msb-circle{background:var(--navy-800);}
.msb-icon.zalo .msb-circle{background:#0068ff;}
.msb-icon.call .msb-circle{background:var(--green);}
.msb-icon.quote .msb-circle{background:var(--orange);}
.msb-label{font-size:10px;font-weight:700;color:var(--ink-soft);}
.msb-icon.menu .msb-label{color:var(--navy-800);}
.msb-icon.zalo .msb-label{color:#0068ff;}
.msb-icon.call .msb-label{color:var(--green);}
.msb-icon.quote .msb-label{color:var(--orange-dark);}
@media(max-width:640px){.mobile-sticky{display:flex;} body{padding-bottom:80px;} .quick-specs{grid-template-columns:1fr;}}

.float-contact{position:fixed;right:22px;bottom:90px;display:flex;flex-direction:column;gap:10px;z-index:45;}
@media(max-width:640px){.float-contact{display:none;}}
.float-contact a{width:50px;height:50px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;box-shadow:0 3px 10px rgba(0,0,0,.2);}
.float-contact .fc-zalo{background:#0068ff;}
.float-contact .fc-call{background:var(--green);}

.menu-sheet-overlay{display:none;position:fixed;inset:0;background:rgba(13,31,51,.55);z-index:110;align-items:flex-end;justify-content:center;}
.menu-sheet-overlay.open{display:flex;}
.menu-sheet{background:#fff;border-radius:16px 16px 0 0;width:100%;max-width:520px;padding:20px 20px calc(20px + env(safe-area-inset-bottom));max-height:80vh;overflow-y:auto;position:relative;}
.menu-sheet-handle{width:38px;height:4px;background:var(--line);border-radius:3px;margin:0 auto 14px;}
.menu-sheet h3{margin:0 0 16px;font-size:16px;color:var(--navy-950);}
.menu-sheet .ms-close{position:absolute;top:16px;right:18px;background:none;border:none;font-size:20px;color:var(--ink-soft);}
.ms-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
.ms-tile{display:flex;flex-direction:column;align-items:center;gap:8px;text-align:center;border:1px solid var(--line);border-radius:12px;padding:16px 8px;background:var(--paper);text-decoration:none;}
.ms-tile .ms-icon{width:44px;height:44px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;font-size:20px;box-shadow:0 2px 6px rgba(13,31,51,.1);}
.ms-tile span:last-child{font-size:11.5px;font-weight:600;color:var(--navy-950);line-height:1.3;}

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
<!-- [BRAND: breadcrumb] — phân cấp hiển thị: Trang chủ › Thương hiệu › Tên hãng.
     URL thật giữ nguyên flat, ví dụ winline.vn/vinawind (không đổi sang path phân cấp). -->
<div class="breadcrumb">
  <a href="{{ route('client.home') }}">Trang chủ</a> › <a href="{{ route('client.brands') }}">Thương hiệu</a> › Vinawind
</div>

<div class="page-head">
  <div>
    <!-- [BRAND: H1 + count] -->
    <h1>Quạt Vinawind chính hãng</h1>
    <div class="count">38 sản phẩm — quạt trần, quạt cây, quạt treo tường, quạt sàn</div>
  </div>
  <div class="sort-wrap">
    Sắp xếp:
    <select>
      <option>Bán chạy nhất</option>
      <option>Giá thấp đến cao</option>
      <option>Giá cao đến thấp</option>
      <option>Đánh giá cao nhất</option>
    </select>
  </div>
</div>

<!-- ============ BRAND-STRIP — khối duy nhất khác biệt theo mẫu của khách ============ -->
<div class="brand-strip">
  <div class="brand-strip-inner">
    <div class="brand-logo-box">
      <img src="{{ asset('client-assets/images/brands/vinawind.png') }}" alt="Vinawind" style="max-width:100%; max-height:42px; object-fit:contain; display:block;">
    </div>
    <div class="brand-strip-text">
      <!-- [BRAND: mô tả 1 câu] — data-cms-field, PHẢI xác nhận đúng quan hệ phân phối thật
           (đại lý ủy quyền / nhà phân phối / đơn thuần bán lại) trước khi lên production,
           không tự suy đoán để tránh sai lệch pháp lý với hãng. -->
      <p data-cms-field="brand_intro_vinawind">Vinawind là dòng quạt chủ lực tại Winline — giá cạnh tranh nhất trong các thương hiệu Winline phân phối. Đầy đủ quạt trần, quạt cây, quạt treo tường, quạt sàn cho cả gia đình và công trình.</p>
      <span class="cms-flag">⚠ Cần Winline xác nhận đúng quan hệ phân phối (đại lý ủy quyền / NPP) trước khi đăng — chưa xác nhận, đang dùng câu trung tính từ dữ liệu nội bộ.</span>
    </div>
    <!-- [BRAND: facts] — chỉ hiện khi có dữ liệu thật, không tự đặt số nếu chưa có nguồn -->
    <div class="brand-facts">
      <span class="brand-fact">Bảo hành 12 tháng</span>
      <span class="brand-fact">Giao hàng toàn quốc</span>
    </div>
  </div>
</div>

<div class="listing">
  <aside class="filters" id="filtersSection">
    <!-- Bộ lọc "Thương hiệu" của category.html được BỎ ở đây — vì cả trang chỉ có 1 hãng,
         lọc theo hãng là thừa. Thay bằng lọc "Loại quạt" để khách thu hẹp trong đúng
         phạm vi Vinawind có bán — đây là điều chỉnh chính so với category.html. -->
    <div class="filter-group">
      <div class="filter-title">Loại quạt</div>
      <label class="filter-opt"><input type="checkbox" checked> Quạt trần <span class="fcount">11</span></label>
      <label class="filter-opt"><input type="checkbox"> Quạt cây <span class="fcount">9</span></label>
      <label class="filter-opt"><input type="checkbox"> Quạt treo tường <span class="fcount">8</span></label>
      <label class="filter-opt"><input type="checkbox"> Quạt đảo trần <span class="fcount">6</span></label>
      <label class="filter-opt"><input type="checkbox"> Quạt hộp <span class="fcount">4</span></label>
    </div>
    <div class="filter-group">
      <div class="filter-title">Theo nhu cầu</div>
      <label class="filter-opt"><input type="checkbox"> Gia đình <span class="fcount">24</span></label>
      <label class="filter-opt"><input type="checkbox"> Công trình <span class="fcount">14</span></label>
    </div>
    <div class="filter-group">
      <div class="filter-title">Khoảng giá</div>
      <div class="price-presets">
        <button class="price-chip">Dưới 1.000.000đ</button>
        <button class="price-chip active">1.000.000đ – 2.500.000đ</button>
        <button class="price-chip">2.500.000đ – 4.000.000đ</button>
        <button class="price-chip">Trên 4.000.000đ</button>
      </div>
    </div>
    <a class="filter-clear" href="#">Xoá tất cả bộ lọc</a>
  </aside>

  <div class="results">
    <div class="prod-grid">

      <div class="prod-card">
        <div class="p-img" style="background:#fff; display:flex; align-items:center; justify-content:center; height:180px; position:relative; padding:10px; border-bottom:1px solid #f0f2f5;"><span class="p-badge">Bán chạy</span><img src="{{ asset('client-assets/images/km750s.jpg') }}" alt="Sản phẩm" style="max-height:160px; max-width:100%; object-fit:contain; margin:auto;" onerror="this.src="{{ asset('client-assets/images/km750s.jpg') }}""></div>
        <div class="p-body">
          <div class="p-name"><a href="{{ route('client.products') }}" style="color:inherit; text-decoration:none;">Quạt trần Vinawind VW-1450</a></div>
          <ul class="p-specs"><li>3 cánh, sải cánh 1.450mm</li><li>Có điều khiển từ xa</li></ul>
          <div class="p-price">1.890.000đ</div>
          <div class="p-bulk">Giá tốt hơn khi mua từ 6 sản phẩm</div>
          <div class="p-rating">★★★★★ <span>4.8 (52)</span></div>
          <div class="p-stock"><span class="d"></span>Còn hàng</div>
        </div>
      </div>

      <div class="prod-card">
        <div class="p-img" style="background:#fff; display:flex; align-items:center; justify-content:center; height:180px; position:relative; padding:10px; border-bottom:1px solid #f0f2f5;"><img src="{{ asset('client-assets/images/km750s.jpg') }}" alt="Sản phẩm" style="max-height:160px; max-width:100%; object-fit:contain; margin:auto;" onerror="this.src="{{ asset('client-assets/images/km750s.jpg') }}""></div>
        <div class="p-body">
          <div class="p-name"><a href="{{ route('client.products') }}" style="color:inherit; text-decoration:none;">Quạt cây Vinawind VW-450S</a></div>
          <ul class="p-specs"><li>Công suất 55W</li><li>3 tốc độ, hẹn giờ</li></ul>
          <div class="p-price">790.000đ</div>
          <div class="p-bulk">Giá tốt hơn khi mua từ 6 sản phẩm</div>
          <div class="p-rating">★★★★★ <span>4.7 (38)</span></div>
          <div class="p-stock"><span class="d"></span>Còn hàng</div>
        </div>
      </div>

      <div class="prod-card">
        <div class="p-img" style="background:#fff; display:flex; align-items:center; justify-content:center; height:180px; position:relative; padding:10px; border-bottom:1px solid #f0f2f5;"><span class="p-badge low">Sắp hết</span><img src="{{ asset('client-assets/images/km750s.jpg') }}" alt="Sản phẩm" style="max-height:160px; max-width:100%; object-fit:contain; margin:auto;" onerror="this.src="{{ asset('client-assets/images/km750s.jpg') }}""></div>
        <div class="p-body">
          <div class="p-name"><a href="{{ route('client.products') }}" style="color:inherit; text-decoration:none;">Quạt treo tường Vinawind VW-400T</a></div>
          <ul class="p-specs"><li>Công suất 50W</li><li>Sải cánh 400mm</li></ul>
          <div class="p-price">650.000đ</div>
          <div class="p-bulk">Giá tốt hơn khi mua từ 6 sản phẩm</div>
          <div class="p-rating">★★★★☆ <span>4.5 (21)</span></div>
          <div class="p-stock"><span class="d"></span>Còn 5 sản phẩm</div>
        </div>
      </div>

      <div class="prod-card">
        <div class="p-img" style="background:#fff; display:flex; align-items:center; justify-content:center; height:180px; position:relative; padding:10px; border-bottom:1px solid #f0f2f5;"><img src="{{ asset('client-assets/images/km750s.jpg') }}" alt="Sản phẩm" style="max-height:160px; max-width:100%; object-fit:contain; margin:auto;" onerror="this.src="{{ asset('client-assets/images/km750s.jpg') }}""></div>
        <div class="p-body">
          <div class="p-name"><a href="{{ route('client.products') }}" style="color:inherit; text-decoration:none;">Quạt sàn Vinawind VW-350Q</a></div>
          <ul class="p-specs"><li>Công suất 45W</li><li>Chân đế chống lật</li></ul>
          <div class="p-price">560.000đ</div>
          <div class="p-bulk">Giá tốt hơn khi mua từ 6 sản phẩm</div>
          <div class="p-rating">★★★★★ <span>4.6 (17)</span></div>
          <div class="p-stock"><span class="d"></span>Còn hàng</div>
        </div>
      </div>

      <div class="prod-card">
        <div class="p-img" style="background:#fff; display:flex; align-items:center; justify-content:center; height:180px; position:relative; padding:10px; border-bottom:1px solid #f0f2f5;"><img src="{{ asset('client-assets/images/km750s.jpg') }}" alt="Sản phẩm" style="max-height:160px; max-width:100%; object-fit:contain; margin:auto;" onerror="this.src="{{ asset('client-assets/images/km750s.jpg') }}""></div>
        <div class="p-body">
          <div class="p-name"><a href="{{ route('client.products') }}" style="color:inherit; text-decoration:none;">Quạt đảo trần Vinawind VW-1400Đ</a></div>
          <ul class="p-specs"><li>3 cánh, sải cánh 1.400mm</li><li>Kèm đèn LED</li></ul>
          <div class="p-price">2.150.000đ</div>
          <div class="p-bulk">Giá tốt hơn khi mua từ 6 sản phẩm</div>
          <div class="p-rating">★★★★★ <span>4.9 (29)</span></div>
          <div class="p-stock"><span class="d"></span>Còn hàng</div>
        </div>
      </div>

      <div class="prod-card">
        <div class="p-img" style="background:#fff; display:flex; align-items:center; justify-content:center; height:180px; position:relative; padding:10px; border-bottom:1px solid #f0f2f5;"><img src="{{ asset('client-assets/images/km750s.jpg') }}" alt="Sản phẩm" style="max-height:160px; max-width:100%; object-fit:contain; margin:auto;" onerror="this.src="{{ asset('client-assets/images/km750s.jpg') }}""></div>
        <div class="p-body">
          <div class="p-name"><a href="{{ route('client.products') }}" style="color:inherit; text-decoration:none;">Quạt hộp Vinawind VW-300H</a></div>
          <ul class="p-specs"><li>Công suất 40W</li><li>Gấp gọn, xách tay</li></ul>
          <div class="p-price">420.000đ</div>
          <div class="p-bulk">Giá tốt hơn khi mua từ 6 sản phẩm</div>
          <div class="p-rating">★★★★☆ <span>4.4 (13)</span></div>
          <div class="p-stock"><span class="d"></span>Còn hàng</div>
        </div>
      </div>

    </div>

    <div class="pagination">
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#">4</a>
      <a href="#">›</a>
    </div>
  </div>
</div>

<!-- UNIVERSAL MASTER FOOTER (COMPACT & MODERN - WINLINE.VN STANDARD) -->
<!-- EXACT 100% FOOTER WINLINE.VN -->
<!-- EXACT 100% FOOTER WINLINE.VN WITH OFFICIAL SOCIAL & LEGAL LINKS -->

<!-- ================= KHỐI MÔ TẢ THƯƠNG HIỆU PHÂN PHỐI ================= -->
<div class="category-desc-wrap">
  <article class="category-desc-box">
    <header class="cdb-header">
      <i class="fas fa-award"></i>
      <h2>Hệ Thống Thương Hiệu Quạt Điện &amp; Thiết Bị Thông Gió Uy Tín Phân Phối Tại Winline.vn</h2>
    </header>

    <div class="cdb-body">
      <p>
        Với hơn 20 năm kinh nghiệm trong ngành thiết bị điện cơ khí và thông gió công nghiệp, <strong>Winline Việt Nam</strong> luôn chọn lọc hợp tác với các nhà sản xuất quạt uy tín hàng đầu trong nước và quốc tế. Mọi sản phẩm xuất kho từ Winline đều được kiểm định chất lượng nghiêm ngặt, có đầy đủ tem chống hàng giả, phiếu bảo hành chính hãng và hỗ trợ hồ sơ pháp lý công trình hoàn chỉnh.
      </p>

      <div class="cdb-grid-cards">
        <div class="cdb-card-item">
          <h4><i class="fas fa-shield-alt"></i> Komasu (Việt Nam - Hàn Quốc)</h4>
          <p>Thương hiệu quạt công nghiệp bán chạy nhất: motor 100% dây đồng nguyên chất, lồng mạ crom siêu bền, sải cánh 500 – 1000mm, độ phủ mát cực đại.</p>
        </div>
        <div class="cdb-card-item">
          <h4><i class="fas fa-star"></i> Panasonic &amp; KDK (Nhật Bản)</h4>
          <p>Đỉnh cao quạt trần và quạt gia dụng: động cơ DC êm ái, công nghệ Econavi cảm biến thông minh, thiết kế hiện đại sang trọng bậc nhất.</p>
        </div>
        <div class="cdb-card-item">
          <h4><i class="fas fa-flag"></i> Vinawind (Điện Cơ Thống Nhất)</h4>
          <p>Thương hiệu quốc dân hơn 50 năm tuổi: giá thành kinh tế nhất, độ bền bỉ vượt trội, phụ tùng thay thế sẵn có, được hàng triệu gia đình tin dùng.</p>
        </div>
        <div class="cdb-card-item">
          <h4><i class="fas fa-gear"></i> Chinghai (Đài Loan)</h4>
          <p>Chuyên quạt đứng, quạt sàn công nghiệp nặng: khung thân gang đúc chắc chắn, sải cánh nhôm dày dặn, chịu môi trường bụi bẩn khắc nghiệt.</p>
        </div>
      </div>

      <div class="cdb-collapse-content" id="th-more-desc">
        <h3><i class="fas fa-handshake"></i> Quyền Lợi Của Khách Hàng Khi Mua Hàng Tại Đại Lý Cấp 1 Winline</h3>
        <ul>
          <li><strong>Cam kết 100% chính hãng:</strong> Bồi thường gấp đôi giá trị đơn hàng nếu phát hiện hàng giả, hàng nhái hoặc linh kiện kém chất lượng.</li>
          <li><strong>Giá đại lý tốt nhất:</strong> Mức chiết khấu từ 5% đến 25% cho các đơn hàng dự án, công trình nhà thầu M&amp;E hoặc khách hàng mua từ 6 sản phẩm.</li>
          <li><strong>Bảo hành chính hãng:</strong> Hỗ trợ kích hoạt bảo hành điện tử hoặc phiếu bảo hành từ 12 – 24 tháng theo tiêu chuẩn của từng hãng, hỗ trợ linh kiện thay thế trọn đời.</li>
          <li><strong>Hồ sơ trình nghiệm thu:</strong> Cung cấp nhanh chóng trọn bộ Catalog, bản vẽ kỹ thuật, chứng chỉ xuất xưởng, CQ/CO và hóa đơn VAT 10%.</li>
        </ul>

        <div class="cdb-highlight-box">
          <strong><i class="fas fa-circle-check"></i> Tra cứu và liên hệ trực tiếp:</strong> Bạn đang cần tư vấn model phù hợp từ thương hiệu cụ thể? Hãy gọi ngay Hotline <strong>0949.761.893</strong> hoặc chat Zalo để nhận báo giá chiết khấu mới nhất trong 5 phút.
        </div>
      </div>

      <div class="cdb-toggle-wrap">
        <button type="button" class="cdb-toggle-btn" onclick="toggleCategoryDesc('th-more-desc', this)">
          <span>Xem thêm quyền lợi &amp; danh sách thương hiệu</span> <i class="fas fa-chevron-down"></i>
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

