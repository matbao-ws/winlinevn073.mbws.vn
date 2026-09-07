@extends('client.layouts.app')

@section('title', 'Winline.vn — Quạt điện, quạt công nghiệp chính hãng')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&family=IBM+Plex+Mono:wght@500;600;700&display=swap');

  :root {
    --brand-blue: #004e7d;
    --brand-blue-hover: #00354f;
    --brand-blue-light: #e6eef3;
    --brand-blue-subtle: #f7f8fa;
    --navy-950: #00354f;
    --navy-900: #00354f;
    --navy-800: #004e7d;
    --navy-700: #1f6690;
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
    --green-bg: #e6f4ee;
    --radius: 6px;
    --radius-lg: 10px;
    --shadow: 0 2px 10px rgba(13, 31, 51, 0.08);
    --shadow-lg: 0 10px 25px rgba(0, 53, 79, 0.12);
  }

  * { box-sizing: border-box; }
  html, body { margin: 0; padding: 0; }
  body {
    font-family: 'Be Vietnam Pro', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--ink);
    background: var(--paper);
    font-size: 15px;
    line-height: 1.55;
    -webkit-font-smoothing: antialiased;
  }

  .mono { font-family: 'IBM Plex Mono', monospace; }
  a { color: inherit; text-decoration: none; transition: color 0.15s ease, opacity 0.15s ease; }
  img { max-width: 100%; display: block; }
  button { font-family: inherit; cursor: pointer; touch-action: manipulation; }

  /* ---------- Utility Bar ---------- */
  
  
  
  
  

  /* ---------- Main Header ---------- */
  
  
  
  
  
  
  
  
  
  
  
  .header-actions .item:hover {
    color: var(--brand-blue);
  }
  

  /* ---------- Category Navigation ---------- */
  
  
  
  
  

  /* Dropdown */
  
  
  
  
  
  
  
  

    /* ---------- MODERN HERO SECTION (DARK NAVY IDENTITY) ---------- */
  .hero {
    background: linear-gradient(120deg, #00354f 0%, #004e7d 100%);
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    padding: 44px 0 0;
    position: relative;
    overflow: hidden;
  }
  .hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
    background-size: 24px 24px;
    pointer-events: none;
    opacity: 0.6;
  }
  .hero-inner {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 20px 40px;
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 40px;
    align-items: center;
    position: relative;
    z-index: 2;
  }
  @media (max-width: 920px) {
    .hero-inner { grid-template-columns: 1fr; gap: 32px; padding-bottom: 30px; }
  }

  .hero-text {
    color: #ffffff;
  }
  .hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.1);
    color: #cfe0f0;
    font-size: 12px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 9999px;
    margin-bottom: 18px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  }
  .hero-eyebrow .dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--orange);
    display: inline-block;
    box-shadow: 0 0 0 3px rgba(212, 30, 61, 0.3);
  }
  .hero-text h1 {
    font-size: 34px;
    line-height: 1.28;
    margin: 0 0 16px;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.02em;
  }
  .hero-text h1 .text-brand {
    color: var(--orange);
    position: relative;
  }
  .hero-desc {
    font-size: 15px;
    color: #c9d6e3;
    line-height: 1.7;
    max-width: 540px;
    margin: 0 0 26px;
  }

  .hero-cta {
    display: flex;
    gap: 14px;
    margin-bottom: 24px;
    flex-wrap: wrap;
  }
  .btn {
    padding: 12px 22px;
    border-radius: var(--radius);
    font-weight: 700;
    font-size: 14.5px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.22s cubic-bezier(0.22, 1, 0.36, 1);
    text-decoration: none;
  }
  .btn-primary {
    background: var(--orange);
    color: #ffffff;
    box-shadow: 0 4px 14px rgba(212, 30, 61, 0.4);
  }
  .btn-primary:hover {
    background: var(--orange-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(212, 30, 61, 0.5);
  }
  .btn-zalo {
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
    border: 1.5px solid rgba(255, 255, 255, 0.35);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  }
  .btn-zalo:hover {
    background: #0068ff;
    border-color: #0068ff;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 104, 255, 0.35);
  }

  .hero-fast-tags {
    display: flex;
    gap: 16px;
    font-size: 12.5px;
    color: #dbe4ee;
    font-weight: 600;
    flex-wrap: wrap;
  }
  .hero-fast-tags span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .hero-fast-tags i {
    color: #4ade80;
  }

  /* Hero Showcase Card */
  .hero-showcase {
    display: flex;
    justify-content: center;
    position: relative;
  }
  .showcase-card {
    background: var(--white);
    border: 1px solid var(--line);
    border-radius: 16px;
    padding: 24px;
    box-shadow: var(--shadow-lg);
    position: relative;
    width: 100%;
    max-width: 440px;
    text-align: center;
  }
  .showcase-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    background: var(--orange);
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 9999px;
    box-shadow: 0 2px 6px rgba(212, 30, 61, 0.3);
  }
  .showcase-img {
    height: 220px;
    width: auto;
    object-fit: contain;
    margin: 10px auto 16px;
    filter: drop-shadow(0 10px 20px rgba(0,0,0,0.08));
    transition: transform 0.3s ease;
  }
  .showcase-card:hover .showcase-img {
    transform: scale(1.04);
  }
  .showcase-brand {
    font-size: 11px;
    font-weight: 700;
    color: var(--brand-blue);
    letter-spacing: 0.05em;
  }
  .showcase-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--navy-950);
    margin: 4px 0 6px;
  }
  .showcase-specs {
    font-size: 12px;
    color: var(--ink-soft);
    margin-bottom: 12px;
  }
  .showcase-price-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 12px;
    border-top: 1px solid var(--line);
  }
  .showcase-price {
    font-size: 20px;
    font-weight: 800;
    color: var(--orange);
    font-family: 'IBM Plex Mono', monospace;
  }
  .showcase-stock {
    font-size: 11.5px;
    color: var(--green);
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .pulse-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--green);
    box-shadow: 0 0 0 2px rgba(30, 138, 95, 0.25);
  }

  /* Floating chips */
  .float-chip {
    position: absolute;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    border: 1px solid var(--line);
    box-shadow: 0 8px 24px rgba(7, 34, 66, 0.12);
    border-radius: 10px;
    padding: 8px 12px;
    display: flex;
    align-items: center;
    gap: 8px;
    text-align: left;
    z-index: 3;
  }
  .chip-top-left {
    top: -12px;
    left: -20px;
  }
  .chip-bottom-right {
    bottom: -14px;
    right: -16px;
  }
  .chip-icon {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    background: var(--brand-blue-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
  }
  .float-chip strong {
    display: block;
    font-size: 12px;
    color: var(--navy-950);
  }
  .float-chip small {
    font-size: 10.5px;
    color: var(--ink-soft);
  }

  @media (max-width: 640px) {
    .float-chip { display: none; }
  }

  /* ---------- TRUST STRIP (DARK NAVY THEME) ---------- */
  .trust-strip {
    background: #00354f;
    background: linear-gradient(90deg, #00354f 0%, #00354f 50%, #004e7d 100%);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    z-index: 2;
  }
  .trust-strip-inner {
    max-width: 1240px;
    margin: 0 auto;
    padding: 22px 20px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
  }
  @media (max-width: 760px) {
    .trust-strip-inner { grid-template-columns: repeat(2, 1fr); gap: 14px; }
  }
  .trust-item {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .ti-icon-box {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.12);
    color: #facc15;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    flex-shrink: 0;
  }
  .trust-item .ti-num {
    font-family: 'IBM Plex Mono', monospace;
    font-size: 17px;
    font-weight: 700;
    color: #ffffff;
    display: block;
    line-height: 1.2;
  }
  .trust-item .ti-label {
    font-size: 11.5px;
    color: #c9d6e3;
    line-height: 1.35;
  }

  /* ---------- SECTIONS & GRIDS ---------- */
  section {
    max-width: 1240px;
    margin: 0 auto;
    padding: 48px 20px;
  }
  .sec-head {
    margin-bottom: 24px;
  }
  .sec-head h2 {
    font-size: 22px;
    color: var(--navy-950);
    margin: 0 0 6px;
    font-weight: 800;
    letter-spacing: -0.01em;
  }
  .sec-head p {
    font-size: 13.5px;
    color: var(--ink-soft);
    margin: 0;
  }

  /* Need Cards */
  .need-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
  }
  @media (max-width: 760px) { .need-grid { grid-template-columns: 1fr; } }
  .need-card {
    border: 1px solid var(--line);
    border-radius: 12px;
    background: var(--white);
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
    box-shadow: var(--shadow-sm);
  }
  .need-card:hover {
    border-color: var(--brand-blue);
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
  }
  .need-card .n-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: var(--brand-blue-light);
    color: var(--brand-blue);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
  }
  .need-card h3 {
    font-size: 17px;
    margin: 4px 0 0;
    color: var(--navy-950);
    font-weight: 700;
  }
  .need-card p {
    font-size: 13px;
    color: var(--ink-soft);
    margin: 0;
    line-height: 1.6;
    flex: 1;
  }
  .need-card .n-link {
    font-size: 13px;
    font-weight: 700;
    color: var(--brand-blue);
    margin-top: 8px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .need-card:hover .n-link {
    color: var(--orange);
  }

  /* Category Grid */
  .cat-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 14px;
  }
  @media (max-width: 760px) { .cat-grid { grid-template-columns: repeat(3, 1fr); } }
  .cat-tile {
    border: 1px solid var(--line);
    border-radius: 10px;
    background: var(--white);
    padding: 18px 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    text-align: center;
    transition: all 0.2s ease;
    box-shadow: var(--shadow-sm);
  }
  .cat-tile:hover {
    border-color: var(--brand-blue);
    transform: translateY(-3px);
    box-shadow: var(--shadow);
  }
  .cat-tile .ct-icon {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: var(--brand-blue-light);
    color: var(--brand-blue);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    transition: background 0.2s ease;
  }
  .cat-tile:hover .ct-icon {
    background: var(--brand-blue);
    color: #ffffff;
  }
  .cat-tile span {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--navy-950);
  }

  /* Product Card */
  .prod-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    gap: 18px;
  }
  .prod-card {
    background: var(--white);
    border: 1px solid var(--line);
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
  }
  .prod-card:hover {
    border-color: var(--brand-blue);
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
  }
  .prod-card .p-img {
    aspect-ratio: 1/1;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    position: relative;
    border-bottom: 1px solid var(--line);
  }
  .prod-card .p-img img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    margin: auto;
    transition: transform 0.3s ease;
  }
  .prod-card:hover .p-img img {
    transform: scale(1.06);
  }
  .prod-card .p-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: var(--orange);
    color: #ffffff;
    font-size: 10.5px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 4px;
  }
  .prod-card .p-body {
    padding: 14px;
    display: flex;
    flex-direction: column;
    flex: 1;
  }
  .prod-card .p-brand {
    font-size: 10.5px;
    color: var(--brand-blue);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 700;
    margin-bottom: 4px;
  }
  .prod-card .p-name {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--navy-950);
    line-height: 1.4;
    min-height: 38px;
    margin-bottom: 8px;
  }
  .prod-card .p-specs {
    list-style: none;
    margin: 0 0 10px;
    padding: 0;
    font-size: 11.5px;
    color: var(--ink-soft);
    line-height: 1.6;
  }
  .prod-card .p-specs li::before {
    content: "• ";
    color: var(--brand-blue);
    font-weight: bold;
  }
  .prod-card .p-price {
    font-weight: 800;
    color: var(--orange);
    font-family: 'IBM Plex Mono', monospace;
    font-size: 16px;
    margin-top: auto;
  }
  .prod-card .p-bulk {
    font-size: 11px;
    color: var(--brand-blue);
    margin-top: 4px;
    font-weight: 600;
  }
  .prod-card .p-stock {
    font-size: 11px;
    color: var(--green);
    font-weight: 700;
    margin-top: 8px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .prod-card .p-stock .d {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: var(--green);
  }

  /* Brand Strip */
  .brand-strip {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 12px;
  }
  @media (max-width: 760px) { .brand-strip { grid-template-columns: repeat(4, 1fr); } }
  .brand-tile {
    border: 1px solid var(--line);
    border-radius: 8px;
    background: var(--white);
    padding: 14px 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: var(--navy-950);
    font-size: 12.5px;
    text-align: center;
    min-height: 54px;
    transition: all 0.2s ease;
  }
  .brand-tile:hover {
    border-color: var(--brand-blue);
    color: var(--brand-blue);
    box-shadow: var(--shadow);
  }

  /* Reception Band */
  .reception-band {
    background: var(--brand-blue-light);
    border-top: 1px solid var(--line);
    border-bottom: 1px solid var(--line);
  }
  .reception-inner {
    max-width: 1240px;
    margin: 0 auto;
    padding: 28px 20px;
    display: flex;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
  }
  .reception-text { flex: 1; min-width: 220px; }
  .reception-text h3 { margin: 0 0 4px; font-size: 17px; color: var(--navy-950); font-weight: 700; }
  .reception-text p { margin: 0; font-size: 13px; color: var(--ink-soft); }
  .reception-staff { display: flex; gap: 12px; flex-wrap: wrap; }
  .r-card {
    background: #ffffff;
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: var(--shadow-sm);
  }
  .r-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    flex-shrink: 0;
  }
  .r-meta { font-size: 11.5px; line-height: 1.35; }
  .r-meta b { display: block; font-size: 12.5px; color: var(--navy-950); }
  .r-zalo {
    background: #0068ff;
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    padding: 5px 10px;
    border-radius: 6px;
    margin-left: 4px;
  }

  /* Footer */
  
  
  @media (max-width: 820px) {  }
  .
  .
  .
</style>
@endpush

@section('content')
<!-- ---------- HERO SECTION ---------- -->
<div class="hero">
  <div class="hero-inner">
    <div class="hero-text">
      <div class="hero-eyebrow">
        <span class="dot"></span> Đại lý ủy quyền Komasu · Tico · Senko · Panasonic · Nedfon · Dasin · Hatari
      </div>
      <h1>Hơn 20 năm cung cấp <span class="text-brand">quạt điện &amp; quạt công nghiệp</span> &mdash; Giao hàng toàn quốc</h1>
      <p class="hero-desc">
        Phân phối trực tiếp từ quạt dân dụng đến hệ thống quạt công nghiệp nhà xưởng, công trình. Tư vấn kỹ thuật đúng chuẩn TCVN, đầy đủ hồ sơ CO/CQ &amp; hóa đơn VAT ngay từ báo giá đầu tiên.
      </p>
      <div class="hero-cta">
        <a href="tel:0949761893" class="btn btn-primary">
          <i class="fas fa-phone-alt"></i> Gọi ngay: 0949 761 893
        </a>
        <a href="https://zalo.me/0949761893" target="_blank" class="btn btn-zalo">
          <i class="fas fa-comment-dots"></i> Chat Zalo tư vấn
        </a>
      </div>
      <div class="hero-fast-tags">
        <span><i class="fas fa-check-circle"></i> Báo giá dự án trong 15p</span>
        <span><i class="fas fa-check-circle"></i> Sẵn kho số lượng lớn</span>
        <span><i class="fas fa-check-circle"></i> Đổi trả 30 ngày</span>
      </div>
    </div>

    <div class="hero-showcase">
      <div class="showcase-card">
        <div class="showcase-badge">Bán chạy nhất 2026</div>
        <img src="{{ asset('client-assets/images/km750s.jpg') }}" alt="Quạt cây công nghiệp Komasu KM-750S" class="showcase-img">
        <div class="showcase-brand">KOMASU NHẬT BẢN</div>
        <div class="showcase-title">Quạt đứng công nghiệp KM-750S</div>
        <div class="showcase-specs">
          <span>Công suất 250W</span> · <span>Sải cánh 750mm</span> · <span>15.200 m³/h</span>
        </div>
        <div class="showcase-price-row">
          <span class="showcase-price">2.630.000₫</span>
          <span class="showcase-stock"><span class="pulse-dot"></span> Sẵn hàng tại kho</span>
        </div>

        <div class="float-chip chip-top-left">
          <div class="chip-icon"><i class="fas fa-bolt" style="color:#f59e0b;"></i></div>
          <div>
            <strong>100% Dây Đồng</strong>
            <small>Vận hành 24/7 êm ái</small>
          </div>
        </div>

        <div class="float-chip chip-bottom-right">
          <div class="chip-icon"><i class="fas fa-shield-halved" style="color:var(--brand-blue);"></i></div>
          <div>
            <strong>Bảo hành 12T</strong>
            <small>Hư gì đổi nấy chính hãng</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="trust-strip">
    <div class="trust-strip-inner">
      <div class="trust-item">
        <div class="ti-icon-box"><i class="fas fa-truck-fast"></i></div>
        <div>
          <span class="ti-num">98–99%</span>
          <span class="ti-label">Đơn hàng giao đúng hẹn</span>
        </div>
      </div>
      <div class="trust-item">
        <div class="ti-icon-box"><i class="fas fa-rotate-left"></i></div>
        <div>
          <span class="ti-num">30 ngày</span>
          <span class="ti-label">Đổi trả miễn phí nếu lỗi</span>
        </div>
      </div>
      <div class="trust-item">
        <div class="ti-icon-box"><i class="fas fa-shield-alt"></i></div>
        <div>
          <span class="ti-num">12 tháng</span>
          <span class="ti-label">Bảo hành hư gì đổi nấy</span>
        </div>
      </div>
      <div class="trust-item">
        <div class="ti-icon-box"><i class="fas fa-file-invoice-dollar"></i></div>
        <div>
          <span class="ti-num">VAT · CQ/CO</span>
          <span class="ti-label">Xuất hoá đơn, hồ sơ đầy đủ</span>
        </div>
      </div>
    </div>
  </div>
</div>

<section>
  <div class="sec-head"><h2>Bạn đang cần mua cho việc gì?</h2><p>Chọn đúng nhu cầu để xem sản phẩm và chính sách phù hợp nhất</p></div>
  <div class="need-grid">
    <a class="need-card" href="{{ route('client.products') }}">
      <div class="n-icon">🏠</div>
      <h3>Mua cho gia đình</h3>
      <p>Quạt trần, quạt cây, quạt treo tường dân dụng — giao nhanh, giá rõ ràng, đổi trả dễ dàng.</p>
      <span class="n-link">Xem sản phẩm →</span>
    </a>
    <a class="need-card" href="{{ route('client.solutions') }}">
      <div class="n-icon">🏭</div>
      <h3>Mua cho nhà xưởng — công trình</h3>
      <p>Quạt công nghiệp, quạt thông gió công suất lớn — có hồ sơ năng lực, bản vẽ lắp đặt, báo giá dự án.</p>
      <span class="n-link">Xem giải pháp →</span>
    </a>
    <a class="need-card" href="{{ route('client.contact') }}">
      <div class="n-icon">📦</div>
      <h3>Mua sỉ — đại lý</h3>
      <p>Nhập hàng số lượng lớn để bán lại — chính sách giá sỉ riêng, hỗ trợ hình ảnh &amp; thông tin sản phẩm.</p>
      <span class="n-link">Nhận báo giá sỉ →</span>
    </a>
  </div>
</section>

<section style="padding-top:0;">
  <div class="sec-head"><h2>Danh mục sản phẩm</h2></div>
  <div class="cat-grid">
    <a class="cat-tile" href="{{ route('client.products') }}"><div class="ct-icon">🌀</div><span>Quạt trần</span></a>
    <a class="cat-tile" href="{{ route('client.products') }}"><div class="ct-icon">🧍</div><span>Quạt cây</span></a>
    <a class="cat-tile" href="{{ route('client.products') }}"><div class="ct-icon">🪟</div><span>Quạt treo tường</span></a>
    <a class="cat-tile" href="{{ route('client.products') }}"><div class="ct-icon">📦</div><span>Quạt hộp</span></a>
    <a class="cat-tile" href="{{ route('client.products') }}"><div class="ct-icon">🏭</div><span>Quạt công nghiệp</span></a>
    <a class="cat-tile" href="{{ route('client.products') }}"><div class="ct-icon">💨</div><span>Quạt thông gió</span></a>
  </div>
</section>

<section style="padding-top:0;">
  <div class="sec-head"><h2>Sản phẩm bán chạy</h2><p>Sắp xếp theo số lượng đã bán, cập nhật liên tục</p></div>
  <div class="prod-grid">
    <div class="prod-card">
      <div class="p-img">
        <span class="p-badge">Bán chạy</span>
        <img src="{{ asset('client-assets/images/km750s.jpg') }}" alt="Quạt cây công nghiệp Komasu KM-750S">
      </div>
      <div class="p-body">
        <div class="p-brand">Komasu</div>
        <div class="p-name"><a href="{{ route('client.products') }}">Quạt cây công nghiệp Komasu KM-750S</a></div>
        <ul class="p-specs"><li>Công suất 250W</li><li>Sải cánh 750mm · 3 tốc độ</li></ul>
        <div class="p-price">2.630.000₫</div>
        <div class="p-bulk">Giá tốt hơn khi mua từ 6 sản phẩm</div>
        <div class="p-stock"><span class="d"></span>Còn hàng</div>
      </div>
    </div>
    <div class="prod-card">
      <div class="p-img">
        <img src="{{ asset('client-assets/images/km750s.jpg') }}" alt="Quạt cây công nghiệp Tico TC-750">
      </div>
      <div class="p-body">
        <div class="p-brand">Tico</div>
        <div class="p-name"><a href="{{ route('client.products') }}">Quạt cây công nghiệp Tico TC-750</a></div>
        <ul class="p-specs"><li>Công suất 220W</li><li>Sải cánh 750mm · 3 tốc độ</li></ul>
        <div class="p-price">2.480.000₫</div>
        <div class="p-bulk">Giá tốt hơn khi mua từ 6 sản phẩm</div>
        <div class="p-stock"><span class="d"></span>Còn hàng</div>
      </div>
    </div>
    <div class="prod-card">
      <div class="p-img">
        <img src="{{ asset('client-assets/images/km750s.jpg') }}" alt="Quạt sàn công nghiệp Senko QS-500">
      </div>
      <div class="p-body">
        <div class="p-brand">Senko</div>
        <div class="p-name"><a href="{{ route('client.products') }}">Quạt sàn công nghiệp Senko QS-500</a></div>
        <ul class="p-specs"><li>Công suất 165W</li><li>Sải cánh 500mm</li></ul>
        <div class="p-price">1.650.000₫</div>
        <div class="p-bulk">Giá tốt hơn khi mua từ 6 sản phẩm</div>
        <div class="p-stock"><span class="d"></span>Còn hàng</div>
      </div>
    </div>
    <div class="prod-card">
      <div class="p-img">
        <img src="{{ asset('client-assets/images/km750s.jpg') }}" alt="Quạt thông gió công nghiệp Kyungjin KR-1000">
      </div>
      <div class="p-body">
        <div class="p-brand">Kyungjin</div>
        <div class="p-name"><a href="{{ route('client.products') }}">Quạt thông gió công nghiệp Kyungjin KR-1000</a></div>
        <ul class="p-specs"><li>Lưu lượng 8.500 m³/h</li><li>Lắp âm trần / tường</li></ul>
        <div class="p-price">4.150.000₫</div>
        <div class="p-bulk">Giá tốt hơn khi mua từ 6 sản phẩm</div>
        <div class="p-stock"><span class="d"></span>Còn hàng</div>
      </div>
    </div>
    <div class="prod-card">
      <div class="p-img">
        <img src="{{ asset('client-assets/images/km750s.jpg') }}" alt="Quạt treo tường công nghiệp Nedfon NF-650">
      </div>
      <div class="p-body">
        <div class="p-brand">Nedfon</div>
        <div class="p-name"><a href="{{ route('client.products') }}">Quạt treo tường công nghiệp Nedfon NF-650</a></div>
        <ul class="p-specs"><li>Công suất 190W</li><li>Sải cánh 650mm</li></ul>
        <div class="p-price">1.890.000₫</div>
        <div class="p-bulk">Giá tốt hơn khi mua từ 6 sản phẩm</div>
        <div class="p-stock"><span class="d"></span>Còn hàng</div>
      </div>
    </div>
  </div>
</section>

<section style="padding-top:0;">
  <div class="sec-head"><h2>Thương hiệu đang phân phối</h2><p>Đại lý ủy quyền chính hãng</p></div>
  <div class="brand-strip">
    <a href="{{ route('client.brands') }}" class="brand-tile">KOMASU</a>
    <a href="{{ route('client.brands') }}" class="brand-tile">TICO</a>
    <a href="{{ route('client.brands') }}" class="brand-tile">SENKO</a>
    <a href="{{ route('client.brands') }}" class="brand-tile">PANASONIC</a>
    <a href="{{ route('client.brands') }}" class="brand-tile">NEDFON</a>
    <a href="{{ route('client.brands') }}" class="brand-tile">NANYOO</a>
    <a href="{{ route('client.brands') }}" class="brand-tile">KYUNGJIN</a>
    <a href="{{ route('client.brands') }}" class="brand-tile">HATARI</a>
  </div>
</section>

<section style="padding-top:0;">
  <div class="sec-head"><h2>Khách hàng nói gì về Winline</h2></div>
  <div class="testi-grid" style="display:grid; grid-template-columns:repeat(3, 1fr); gap:16px;">
    <div style="background:#fff; border:1px solid var(--line); border-radius:12px; padding:20px; box-shadow:var(--shadow-sm);">
      <div style="color:var(--orange); font-size:13px; margin-bottom:10px;">★★★★★</div>
      <p style="font-size:13.5px; color:var(--ink); line-height:1.65; margin:0 0 14px;">Đặt 8 quạt công nghiệp cho xưởng may, giao đúng hẹn dù đơn gấp. Nhân viên tư vấn đúng công suất theo diện tích, không phải tự đoán.</p>
      <div style="display:flex; align-items:center; gap:10px;">
        <div style="width:34px; height:34px; border-radius:50%; background:var(--brand-blue-light); color:var(--brand-blue); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px;">D</div>
        <div style="font-size:12px; color:var(--ink-soft);"><strong style="display:block; color:var(--navy-950); font-size:13px;">Anh Dũng</strong>Xưởng may — Đông Anh, Hà Nội</div>
      </div>
    </div>
    <div style="background:#fff; border:1px solid var(--line); border-radius:12px; padding:20px; box-shadow:var(--shadow-sm);">
      <div style="color:var(--orange); font-size:13px; margin-bottom:10px;">★★★★★</div>
      <p style="font-size:13.5px; color:var(--ink); line-height:1.65; margin:0 0 14px;">Mua sỉ 20 quạt trần về bán lại, có bảng giá rõ ràng theo số lượng, không phải mặc cả từng đơn như chỗ khác.</p>
      <div style="display:flex; align-items:center; gap:10px;">
        <div style="width:34px; height:34px; border-radius:50%; background:var(--brand-blue-light); color:var(--brand-blue); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px;">H</div>
        <div style="font-size:12px; color:var(--ink-soft);"><strong style="display:block; color:var(--navy-950); font-size:13px;">Chị Hằng</strong>Cửa hàng điện máy — Bắc Ninh</div>
      </div>
    </div>
    <div style="background:#fff; border:1px solid var(--line); border-radius:12px; padding:20px; box-shadow:var(--shadow-sm);">
      <div style="color:var(--orange); font-size:13px; margin-bottom:10px;">★★★★★</div>
      <p style="font-size:13.5px; color:var(--ink); line-height:1.65; margin:0 0 14px;">Công trình cần gấp hồ sơ CQ/CO để trình chủ đầu tư, Winline gửi đủ trong ngày, không phải chờ đợi nhiều lần.</p>
      <div style="display:flex; align-items:center; gap:10px;">
        <div style="width:34px; height:34px; border-radius:50%; background:var(--brand-blue-light); color:var(--brand-blue); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px;">M</div>
        <div style="font-size:12px; color:var(--ink-soft);"><strong style="display:block; color:var(--navy-950); font-size:13px;">Anh Minh</strong>Nhà thầu cơ điện — Hà Nội</div>
      </div>
    </div>
  </div>
</section>

<div class="reception-band">
  <div class="reception-inner">
    <div class="reception-text">
      <h3>Cần tư vấn nhanh?</h3>
      <p>Đội tư vấn Winline sẵn sàng hỗ trợ trong giờ làm việc — chọn đúng người phụ trách để được phản hồi nhanh nhất.</p>
    </div>
    <div class="reception-staff">
      <div class="r-card">
        <div class="r-avatar" style="background:var(--orange);">KH</div>
        <div class="r-meta"><b>Kim Huệ</b>Tư vấn mua lẻ, mua nhanh</div>
        <a class="r-zalo" href="https://zalo.me/0949761893" target="_blank">Zalo</a>
      </div>
      <div class="r-card">
        <div class="r-avatar" style="background:var(--brand-blue);">NY</div>
        <div class="r-meta"><b>Ngọc Yến</b>Tư vấn công trình, B2B</div>
        <a class="r-zalo" href="https://zalo.me/0949761893" target="_blank">Zalo</a>
      </div>
    </div>
  </div>
</div>

<!-- UNIVERSAL MASTER FOOTER (COMPACT & MODERN - WINLINE.VN STANDARD) -->
<!-- EXACT 100% FOOTER WINLINE.VN -->
<!-- EXACT 100% FOOTER WINLINE.VN WITH OFFICIAL SOCIAL & LEGAL LINKS -->
<!-- Footer -->
@endsection


