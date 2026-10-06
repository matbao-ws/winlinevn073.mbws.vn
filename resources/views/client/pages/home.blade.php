@extends('client.layouts.app')

@section('title', 'Winline.vn — Quạt điện, quạt công nghiệp chính hãng')

@push('styles')
<style>
  :root {
    --brand-blue: #004e7d;
    --brand-blue-hover: #00354f;
    --brand-blue-light: #e6eef3;
    --brand-blue-subtle: #f8fafc;
    --navy-950: #00354f;
    --navy-900: #00354f;
    --navy-800: #004e7d;
    --ink: #1a2230;
    --ink-soft: #5c6773;
    --line: #dde3ea;
    --red-cta: #cb2027;
    --red-cta-hover: #b01920;
    --white: #ffffff;
    --paper: #f8fafc;
  }

  .v8-container {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 20px;
  }

  /* 1. Hero Section - Full Background Panoramic Banner */
  .v8-hero {
    position: relative;
    width: 100%;
    background-color: #f8fafc;
    border-bottom: 1px solid var(--line);
    overflow: hidden;
  }
  .v8-hero-banner {
    position: relative;
    width: 100%;
    min-height: 480px;
    background-size: cover;
    background-position: center 20%;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
  }
  .v8-hero-overlay {
    position: absolute;
    inset: 0;
    pointer-events: none;
    background: linear-gradient(90deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 36%, rgba(255,255,255,0.40) 52%, rgba(255,255,255,0) 68%);
  }
  .v8-hero .v8-container {
    position: relative;
    z-index: 2;
    width: 100%;
  }
  .v8-hero-content {
    max-width: 520px;
    padding: 56px 0;
  }
  .v8-hero-tag {
    display: inline-block;
    font-size: 12.5px;
    font-weight: 800;
    color: var(--brand-blue);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 14px;
  }
  .v8-hero-title {
    font-size: 38px;
    line-height: 1.22;
    font-weight: 800;
    color: var(--navy-950);
    margin: 0 0 16px;
    letter-spacing: -0.025em;
  }
  .v8-hero-desc {
    font-size: 15px;
    color: #334155;
    line-height: 1.6;
    margin: 0 0 24px;
    max-width: 460px;
    font-weight: 450;
  }
  .v8-hero-actions {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .v8-btn-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--red-cta);
    color: #ffffff !important;
    font-size: 14.5px;
    font-weight: 700;
    padding: 13px 28px;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.15s ease, transform 0.15s ease, box-shadow 0.15s ease;
    box-shadow: 0 4px 14px rgba(203, 32, 39, 0.28);
  }
  .v8-btn-cta:hover {
    background: var(--red-cta-hover);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(203, 32, 39, 0.38);
  }
  @media (max-width: 1024px) {
    .v8-hero-banner {
      min-height: 420px;
      background-position: 65% 20%;
    }
    .v8-hero-title {
      font-size: 32px;
    }
    .v8-hero-content {
      padding: 44px 0;
      max-width: 460px;
    }
  }
  @media (max-width: 768px) {
    .v8-hero-banner {
      min-height: 380px;
      background-position: 60% 15%;
    }
    .v8-hero-overlay {
      background: linear-gradient(90deg, rgba(255,255,255,0.96) 0%, rgba(255,255,255,0.90) 68%, rgba(255,255,255,0.70) 100%);
    }
    .v8-hero-title {
      font-size: 26px;
    }
    .v8-hero-desc {
      font-size: 14px;
      margin-bottom: 20px;
    }
    .v8-hero-content {
      padding: 36px 0;
      max-width: 100%;
    }
    .v8-btn-cta {
      padding: 12px 24px;
      font-size: 14px;
    }
  }

  /* Section Header */
  .v8-sec-header {
    margin-bottom: 20px;
  }
  .v8-sec-header-row {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-bottom: 20px;
    gap: 16px;
  }
  .v8-sec-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--navy-950);
    margin: 0 0 6px;
    letter-spacing: -0.01em;
  }
  .v8-sec-subtitle {
    font-size: 13.5px;
    color: var(--ink-soft);
    margin: 0;
  }
  .v8-link-all {
    font-size: 13px;
    font-weight: 700;
    color: var(--brand-blue);
    text-decoration: none;
    transition: color 0.15s ease;
    white-space: nowrap;
  }
  .v8-link-all:hover {
    color: var(--red-cta);
    text-decoration: underline;
  }

  /* 2. Demand Section (3 cards) */
  .v8-demand-section {
    padding: 36px 0 24px;
  }
  .v8-demand-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
  }
  @media (max-width: 860px) {
    .v8-demand-grid {
      grid-template-columns: 1fr;
      gap: 16px;
    }
  }
  .v8-demand-card {
    background: #ffffff;
    border: 1px solid var(--line);
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }
  .v8-demand-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 6px 18px rgba(0, 78, 125, 0.08);
  }
  .v8-demand-img-wrap {
    height: 180px;
    background: #f1f5f9;
    overflow: hidden;
  }
  .v8-demand-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }
  .v8-demand-card:hover .v8-demand-img-wrap img {
    transform: scale(1.03);
  }
  .v8-demand-info {
    padding: 18px 20px 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
  }
  .v8-demand-name {
    font-size: 16px;
    font-weight: 700;
    color: var(--navy-950);
    margin: 0 0 6px;
  }
  .v8-demand-desc {
    font-size: 13px;
    color: var(--ink-soft);
    margin: 0 0 16px;
    line-height: 1.5;
    flex: 1;
  }
  .v8-btn-red {
    display: inline-block;
    align-self: flex-start;
    background: var(--red-cta);
    color: #ffffff !important;
    font-size: 13px;
    font-weight: 700;
    padding: 8px 18px;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.15s ease;
  }
  .v8-btn-red:hover {
    background: var(--red-cta-hover);
  }

  /* 3. Category Grid 2x6 */
  .v8-cat-section {
    padding: 24px 0;
  }
  .v8-cat-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 14px;
  }
  @media (max-width: 960px) {
    .v8-cat-grid {
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
    }
  }
  @media (max-width: 540px) {
    .v8-cat-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 8px;
    }
  }
  .v8-cat-tile {
    background: #ffffff;
    border: 1px solid var(--line);
    border-radius: 8px;
    padding: 16px 10px 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
  }
  .v8-cat-tile:hover {
    border-color: var(--brand-blue);
    box-shadow: 0 6px 18px rgba(0, 78, 125, 0.12);
    transform: translateY(-3px);
  }
  .v8-cat-tile-thumb {
    width: 86px;
    height: 86px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    overflow: hidden;
  }
  .v8-cat-tile-thumb img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.25s ease;
  }
  .v8-cat-tile:hover .v8-cat-tile-thumb img {
    transform: scale(1.08);
  }
  .v8-cat-tile-name {
    font-size: 13px;
    font-weight: 700;
    color: var(--navy-950);
    line-height: 1.35;
    transition: color 0.15s ease;
  }
  .v8-cat-tile:hover .v8-cat-tile-name {
    color: var(--brand-blue);
  }

  /* 4. B2B Corporate Banner 50/50 */
  .v8-b2b-section {
    padding: 24px 0;
  }
  .v8-b2b-box {
    display: grid;
    grid-template-columns: 1fr 1fr;
    border-radius: 8px;
    overflow: hidden;
    background: var(--brand-blue);
  }
  @media (max-width: 820px) {
    .v8-b2b-box {
      grid-template-columns: 1fr;
    }
  }
  .v8-b2b-text-col {
    padding: 40px 36px;
    color: #ffffff;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .v8-b2b-title {
    font-size: 24px;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 12px;
    line-height: 1.3;
  }
  .v8-b2b-desc {
    font-size: 13.5px;
    line-height: 1.65;
    color: #e0f2fe;
    margin: 0 0 24px;
    max-width: 440px;
  }
  .v8-b2b-btn {
    display: inline-block;
    align-self: flex-start;
    background: var(--red-cta);
    color: #ffffff !important;
    font-size: 13.5px;
    font-weight: 700;
    padding: 10px 22px;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.15s ease;
  }
  .v8-b2b-btn:hover {
    background: var(--red-cta-hover);
  }
  .v8-b2b-img-col {
    background: #00354f;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }
  .v8-b2b-img-col img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    min-height: 240px;
  }

  /* 5 & 7. Product Grid 5 Cards */
  .v8-product-section {
    padding: 24px 0;
  }
  .v8-prod-grid-5 {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
  }
  @media (max-width: 1080px) {
    .v8-prod-grid-5 {
      grid-template-columns: repeat(3, 1fr);
      gap: 12px;
    }
  }
  @media (max-width: 640px) {
    .v8-prod-grid-5 {
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
    }
  }
  .v8-prod-card {
    background: #ffffff;
    border: 1px solid var(--line);
    border-radius: 6px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
  }
  .v8-prod-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
  }
  .v8-prod-thumb {
    aspect-ratio: 1 / 1;
    background: #ffffff;
    padding: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid #f1f5f9;
  }
  .v8-prod-thumb img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.2s ease;
  }
  .v8-prod-card:hover .v8-prod-thumb img {
    transform: scale(1.04);
  }
  .v8-prod-body {
    padding: 12px 14px 14px;
    display: flex;
    flex-direction: column;
    flex: 1;
    text-align: center;
  }
  .v8-prod-name {
    font-size: 13px;
    font-weight: 700;
    color: var(--navy-950);
    margin: 0 0 8px;
    line-height: 1.4;
    min-height: 36px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .v8-prod-name a {
    color: inherit;
    text-decoration: none;
  }
  .v8-prod-name a:hover {
    color: var(--brand-blue);
  }
  .v8-prod-price {
    font-size: 15.5px;
    font-weight: 800;
    color: var(--red-cta);
    font-family: 'IBM Plex Mono', monospace;
    margin: auto 0 10px;
  }
  .v8-prod-btn {
    font-size: 12px;
    font-weight: 700;
    color: var(--brand-blue);
    text-decoration: none;
    padding: 5px 0;
    border-top: 1px solid #f1f5f9;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    transition: color 0.15s ease;
  }
  .v8-prod-btn:hover {
    color: var(--red-cta);
  }

  /* 6. Brand Banner Strip Continuous */
  .v8-brand-strip-section {
    padding: 24px 0;
  }
  .v8-brand-banner-strip {
    background: var(--brand-blue);
    border-radius: 8px;
    padding: 20px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
  }
  @media (max-width: 860px) {
    .v8-brand-banner-strip {
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
      padding: 14px;
    }
  }
  .v8-brand-col {
    display: flex;
    flex-direction: column;
    text-decoration: none;
    transition: transform 0.2s ease, opacity 0.2s ease;
  }
  .v8-brand-col:hover {
    transform: translateY(-2px);
    opacity: 0.95;
  }
  .v8-brand-name {
    font-size: 17px;
    font-weight: 800;
    color: #ffffff;
    text-align: center;
    margin-bottom: 10px;
    letter-spacing: 0.03em;
    text-transform: uppercase;
  }
  .v8-brand-img-box {
    border: 2px solid rgba(255, 255, 255, 0.45);
    border-radius: 6px;
    overflow: hidden;
    height: 170px;
    background: #00354f;
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
  }
  .v8-brand-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.35s ease;
  }
  .v8-brand-col:hover .v8-brand-img-box {
    border-color: #ffffff;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
  }
  .v8-brand-col:hover .v8-brand-img-box img {
    transform: scale(1.05);
  }

  /* 8. Sector 2 Columns */
  .v8-sector-section {
    padding: 24px 0;
  }
  .v8-sector-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }
  @media (max-width: 860px) {
    .v8-sector-grid {
      grid-template-columns: 1fr;
      gap: 16px;
    }
  }
  .v8-sector-card {
    background: #ffffff;
    border: 1px solid var(--line);
    border-radius: 8px;
    padding: 20px;
    display: flex;
    flex-direction: column;
  }
  .v8-sector-header {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 16px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
  }
  .v8-sector-title {
    font-size: 17px;
    font-weight: 800;
    color: var(--navy-950);
    margin: 0 0 4px;
  }
  .v8-sector-desc {
    font-size: 12.5px;
    color: var(--ink-soft);
    margin: 0 0 8px;
    line-height: 1.45;
  }
  .v8-sector-link {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--brand-blue);
    text-decoration: none;
  }
  .v8-sector-link:hover {
    color: var(--red-cta);
    text-decoration: underline;
  }
  .v8-sector-banner-thumb {
    width: 120px;
    height: 68px;
    border-radius: 6px;
    overflow: hidden;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
  }
  .v8-sector-banner-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }
  .v8-sector-card:hover .v8-sector-banner-thumb img {
    transform: scale(1.06);
  }
  .v8-sector-items {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
  }
  .v8-sector-item {
    border: 1px solid #f1f5f9;
    border-radius: 6px;
    padding: 10px 8px;
    text-align: center;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    background: #fafbfc;
    transition: background 0.15s ease, border-color 0.15s ease;
  }
  .v8-sector-item:hover {
    background: #ffffff;
    border-color: #cbd5e1;
  }
  .v8-sector-item-img {
    height: 65px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 6px;
  }
  .v8-sector-item-img img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
  }
  .v8-sector-item-title {
    font-size: 11.5px;
    font-weight: 600;
    color: var(--navy-950);
    line-height: 1.3;
    margin-bottom: 4px;
    min-height: 30px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .v8-sector-item-price {
    font-size: 13px;
    font-weight: 800;
    color: var(--red-cta);
    font-family: 'IBM Plex Mono', monospace;
    margin-top: auto;
  }

  /* 9. About Winline Block */
  .v8-about-section {
    padding: 24px 0 40px;
  }
  .v8-about-box {
    border: 1px solid var(--line);
    border-radius: 8px;
    background: #ffffff;
    padding: 28px 32px;
    display: grid;
    grid-template-columns: 1fr 1.6fr;
    gap: 32px;
    align-items: center;
  }
  @media (max-width: 780px) {
    .v8-about-box {
      grid-template-columns: 1fr;
      gap: 16px;
      padding: 20px;
    }
  }
  .v8-about-title {
    font-size: 21px;
    font-weight: 800;
    color: var(--navy-950);
    margin: 0;
    line-height: 1.35;
  }
  .v8-about-text {
    font-size: 13.5px;
    color: var(--ink-soft);
    line-height: 1.65;
    margin: 0 0 12px;
  }
  .v8-about-link {
    font-size: 13px;
    font-weight: 700;
    color: var(--brand-blue);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .v8-about-link:hover {
    color: var(--red-cta);
    text-decoration: underline;
  }
</style>
@endpush

@section('content')

<!-- 1. HERO SECTION (B2B + B2C) -->
<section class="v8-hero">
  <div class="v8-hero-banner" style="background-image: url('{{ asset('client-assets/images/v8/hero_collage.jpg') }}');">
    <div class="v8-hero-overlay"></div>
    <div class="v8-container">
      <div class="v8-hero-content">
        <span class="v8-hero-tag">GIẢI PHÁP THÔNG GIÓ VÀ LÀM MÁT</span>
        <h1 class="v8-hero-title">Quạt cho gia đình<br>và nơi làm việc</h1>
        <p class="v8-hero-desc">Đa dạng sản phẩm, phù hợp cho không gian sống, văn phòng, nhà xưởng và kho bãi.</p>
        <div class="v8-hero-actions">
          <a href="{{ route('client.products') }}" class="v8-btn-cta">Khám phá sản phẩm →</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 2. KHỐI CHỌN THEO NHU CẦU -->
<section class="v8-demand-section">
  <div class="v8-container">
    <div class="v8-sec-header">
      <h2 class="v8-sec-title">Chọn theo nhu cầu</h2>
      <p class="v8-sec-subtitle">Tìm nhanh sản phẩm phù hợp với không gian của bạn</p>
    </div>
    <div class="v8-demand-grid">
      <!-- 2.1 Quạt cho gia đình, văn phòng -->
      <div class="v8-demand-card">
        <div class="v8-demand-img-wrap">
          <img src="{{ asset('client-assets/images/v8/demand_residential.jpg') }}" alt="Quạt cho gia đình, văn phòng">
        </div>
        <div class="v8-demand-info">
          <h3 class="v8-demand-name">Quạt cho gia đình, văn phòng</h3>
          <p class="v8-demand-desc">Làm mát không gian sống thoải mái hơn.</p>
          <a href="{{ url(app()->getLocale() . '/quat-dan-dung') }}" class="v8-btn-red">Xem cách chọn</a>
        </div>
      </div>

      <!-- 2.2 Quạt cho nhà xưởng, kho bãi -->
      <div class="v8-demand-card">
        <div class="v8-demand-img-wrap">
          <img src="{{ asset('client-assets/images/v8/demand_workshop.jpg') }}" alt="Quạt cho nhà xưởng, kho bãi">
        </div>
        <div class="v8-demand-info">
          <h3 class="v8-demand-name">Quạt cho nhà xưởng, kho bãi</h3>
          <p class="v8-demand-desc">Giải pháp làm mát hiệu quả cho sản xuất, kho hàng.</p>
          <a href="{{ route('client.demands') }}" class="v8-btn-red">Xem cách chọn</a>
        </div>
      </div>

      <!-- 2.3 Làm mát nhà xưởng -->
      <div class="v8-demand-card">
        <div class="v8-demand-img-wrap">
          <img src="{{ asset('client-assets/images/v8/demand_coolingpad.jpg') }}" alt="Làm mát nhà xưởng">
        </div>
        <div class="v8-demand-info">
          <h3 class="v8-demand-name">Làm mát nhà xưởng</h3>
          <p class="v8-demand-desc">Giải pháp thông gió, hút khí và làm mát công nghiệp.</p>
          <a href="{{ url(app()->getLocale() . '/tam-lam-mat-cooling-pad') }}" class="v8-btn-red">Xem cách chọn</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 3. KHỐI DANH MỤC SẢN PHẨM (LƯỚI 2x6 = 12 Ô) -->
<section class="v8-cat-section">
  <div class="v8-container">
    <div class="v8-sec-header-row">
      <h2 class="v8-sec-title">Danh mục sản phẩm</h2>
      <a href="{{ route('client.products') }}" class="v8-link-all">Xem tất cả danh mục →</a>
    </div>
    <div class="v8-cat-grid">
      @php
        $cat12 = [
          ['name' => 'Quạt trần', 'slug' => 'quat-tran', 'img' => 'quat_tran.jpg'],
          ['name' => 'Quạt đứng', 'slug' => 'quat-cay', 'img' => 'quat_dung.jpg'],
          ['name' => 'Quạt treo tường', 'slug' => 'quat-treo-tuong', 'img' => 'quat_treo_tuong.jpg'],
          ['name' => 'Quạt hộp', 'slug' => 'quat-hop', 'img' => 'quat_hop.jpg'],
          ['name' => 'Quạt thông gió', 'slug' => 'quat-thong-gio', 'img' => 'quat_thong_gio.jpg'],
          ['name' => 'Quạt công nghiệp', 'slug' => 'quat-cong-nghiep', 'img' => 'quat_cong_nghiep.jpg'],
          ['name' => 'Quạt cắt gió', 'slug' => 'quat-cat-gio', 'img' => 'quat_cat_gio.jpg'],
          ['name' => 'Quạt phun sương', 'slug' => 'quat-cong-nghiep', 'img' => 'quat_phun_suong.jpg'],
          ['name' => 'Quạt để bàn', 'slug' => 'quat-dan-dung', 'img' => 'quat_de_ban.jpg'],
          ['name' => 'Quạt hút công nghiệp', 'slug' => 'quat-thong-gio-vuong', 'img' => 'quat_hut_cong_nghiep.jpg'],
          ['name' => 'Quạt ống gió', 'slug' => 'quat-ly-tam', 'img' => 'quat_ong_gio.jpg'],
          ['name' => 'Quạt chuyên dụng', 'slug' => 'tam-lam-mat-cooling-pad', 'img' => 'quat_chuyen_dung.jpg'],
        ];
      @endphp
      @foreach($cat12 as $c)
        <a href="{{ url(app()->getLocale() . '/' . $c['slug']) }}" class="v8-cat-tile">
          <div class="v8-cat-tile-thumb">
            <img src="{{ asset('client-assets/images/v8/' . $c['img']) }}" alt="{{ $c['name'] }}">
          </div>
          <span class="v8-cat-tile-name">{{ $c['name'] }}</span>
        </a>
      @endforeach
    </div>
  </div>
</section>

<!-- 4. KHỐI B2B HỒ SƠ CHO ĐƠN HÀNG DOANH NGHIỆP (TỶ LỆ 50/50) -->
<section class="v8-b2b-section">
  <div class="v8-container">
    <div class="v8-b2b-box">
      <div class="v8-b2b-text-col">
        <h2 class="v8-b2b-title">Hồ sơ cho đơn hàng<br>doanh nghiệp</h2>
        <p class="v8-b2b-desc">
          Thông tin xuất xứ, chất lượng và chứng từ được xác nhận theo từng mặt hàng, từng đơn. Xem tài liệu và gửi danh sách để nhận báo giá.
        </p>
        <a href="{{ route('client.about') }}#ho-so-nang-luc" class="v8-b2b-btn">Xem thông tin doanh nghiệp →</a>
      </div>
      <div class="v8-b2b-img-col">
        <img src="{{ asset('client-assets/images/v8/b2b_corporate_warehouse.jpg') }}" alt="Hồ sơ cho đơn hàng doanh nghiệp Winline">
      </div>
    </div>
  </div>
</section>

<!-- 5. SẢN PHẨM NỔI BẬT (5 CARDS) -->
<section class="v8-product-section">
  <div class="v8-container">
    <div class="v8-sec-header-row">
      <h2 class="v8-sec-title">Sản phẩm nổi bật</h2>
      <a href="{{ route('client.products') }}" class="v8-link-all">Xem tất cả sản phẩm →</a>
    </div>
    <div class="v8-prod-grid-5">
      @foreach($featuredProducts->take(5) as $fp)
        <div class="v8-prod-card">
          <a href="{{ url(app()->getLocale() . '/' . ($fp->canonicalSlug(app()->getLocale()) ?: $fp->slug)) }}" class="v8-prod-thumb">
            <img src="{{ asset($fp->image_url ?: 'client-assets/images/placeholder.png') }}" alt="{{ $fp->name }}">
          </a>
          <div class="v8-prod-body">
            <h3 class="v8-prod-name">
              <a href="{{ url(app()->getLocale() . '/' . ($fp->canonicalSlug(app()->getLocale()) ?: $fp->slug)) }}">{{ $fp->name }}</a>
            </h3>
            <div class="v8-prod-price">{{ number_format($fp->price, 0, ',', '.') }}₫</div>
            <a href="{{ url(app()->getLocale() . '/' . ($fp->canonicalSlug(app()->getLocale()) ?: $fp->slug)) }}" class="v8-prod-btn">Xem chi tiết →</a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- 6. DẢI 4 THƯƠNG HIỆU GIỮA TRANG (LIÊN TỤC TRÊN NỀN XANH) -->
<section class="v8-brand-strip-section">
  <div class="v8-container">
    <div class="v8-brand-banner-strip">
      <!-- Vinawind -->
      <a href="{{ url(app()->getLocale() . '/vinawind') }}" class="v8-brand-col">
        <div class="v8-brand-name">Vinawind</div>
        <div class="v8-brand-img-box">
          <img src="{{ asset('client-assets/images/v8/brand_vinawind_v8.jpg') }}" alt="Thương hiệu Vinawind">
        </div>
      </a>

      <!-- KOMASU -->
      <a href="{{ url(app()->getLocale() . '/komasu') }}" class="v8-brand-col">
        <div class="v8-brand-name">KOMASU</div>
        <div class="v8-brand-img-box">
          <img src="{{ asset('client-assets/images/v8/brand_komasu_v8.jpg') }}" alt="Thương hiệu KOMASU">
        </div>
      </a>

      <!-- Chinghai -->
      <a href="{{ url(app()->getLocale() . '/chinghai') }}" class="v8-brand-col">
        <div class="v8-brand-name">Chinghai</div>
        <div class="v8-brand-img-box">
          <img src="{{ asset('client-assets/images/v8/brand_chinghai_v8.jpg') }}" alt="Thương hiệu Chinghai">
        </div>
      </a>

      <!-- NANYOO -->
      <a href="{{ url(app()->getLocale() . '/nanyoo') }}" class="v8-brand-col">
        <div class="v8-brand-name">NANYOO</div>
        <div class="v8-brand-img-box">
          <img src="{{ asset('client-assets/images/v8/brand_nanyoo_v8.jpg') }}" alt="Thương hiệu NANYOO">
        </div>
      </a>
    </div>
  </div>
</section>

<!-- 7. SẢN PHẨM VỪA CẬP NHẬT (5 CARDS) -->
<section class="v8-product-section" style="padding-top: 10px;">
  <div class="v8-container">
    <div class="v8-sec-header-row">
      <h2 class="v8-sec-title">Sản phẩm vừa cập nhật</h2>
      <a href="{{ route('client.products') }}" class="v8-link-all">Xem tất cả sản phẩm →</a>
    </div>
    <div class="v8-prod-grid-5">
      @foreach($recentProducts->take(5) as $rp)
        <div class="v8-prod-card">
          <a href="{{ url(app()->getLocale() . '/' . ($rp->canonicalSlug(app()->getLocale()) ?: $rp->slug)) }}" class="v8-prod-thumb">
            <img src="{{ asset($rp->image_url ?: 'client-assets/images/placeholder.png') }}" alt="{{ $rp->name }}">
          </a>
          <div class="v8-prod-body">
            <h3 class="v8-prod-name">
              <a href="{{ url(app()->getLocale() . '/' . ($rp->canonicalSlug(app()->getLocale()) ?: $rp->slug)) }}">{{ $rp->name }}</a>
            </h3>
            <div class="v8-prod-price">{{ number_format($rp->price, 0, ',', '.') }}₫</div>
            <a href="{{ url(app()->getLocale() . '/' . ($rp->canonicalSlug(app()->getLocale()) ?: $rp->slug)) }}" class="v8-prod-btn">Xem chi tiết →</a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- 8. KHỐI 2 CỘT NGÀNH HÀNG CHÍNH -->
<section class="v8-sector-section">
  <div class="v8-container">
    <div class="v8-sector-grid">
      <!-- Cột 1: Quạt điện dân dụng -->
      <div class="v8-sector-card">
        <div class="v8-sector-header">
          <div>
            <h3 class="v8-sector-title">Quạt điện dân dụng</h3>
            <p class="v8-sector-desc">Giải pháp làm mát cho gia đình, văn phòng và cửa hàng.</p>
            <a href="{{ url(app()->getLocale() . '/quat-dan-dung') }}" class="v8-sector-link">Xem tất cả →</a>
          </div>
          <div class="v8-sector-banner-thumb">
            <img src="{{ asset('client-assets/images/v8/sector_residential.jpg') }}" alt="Quạt điện dân dụng">
          </div>
        </div>
        <div class="v8-sector-items">
          @foreach($residentialProducts->take(3) as $resp)
            <a href="{{ url(app()->getLocale() . '/' . ($resp->canonicalSlug(app()->getLocale()) ?: $resp->slug)) }}" class="v8-sector-item">
              <div class="v8-sector-item-img">
                <img src="{{ asset($resp->image_url ?: 'client-assets/images/placeholder.png') }}" alt="{{ $resp->name }}">
              </div>
              <div class="v8-sector-item-title">{{ Str::limit($resp->name, 35) }}</div>
              <div class="v8-sector-item-price">{{ number_format($resp->price, 0, ',', '.') }}₫</div>
            </a>
          @endforeach
        </div>
      </div>

      <!-- Cột 2: Quạt công nghiệp -->
      <div class="v8-sector-card">
        <div class="v8-sector-header">
          <div>
            <h3 class="v8-sector-title">Quạt công nghiệp</h3>
            <p class="v8-sector-desc">Thông gió và làm mát hiệu quả cho nhà xưởng, kho bãi.</p>
            <a href="{{ url(app()->getLocale() . '/quat-cong-nghiep') }}" class="v8-sector-link">Xem tất cả →</a>
          </div>
          <div class="v8-sector-banner-thumb">
            <img src="{{ asset('client-assets/images/v8/sector_industrial.jpg') }}" alt="Quạt công nghiệp">
          </div>
        </div>
        <div class="v8-sector-items">
          @foreach($industrialProducts->take(3) as $indp)
            <a href="{{ url(app()->getLocale() . '/' . ($indp->canonicalSlug(app()->getLocale()) ?: $indp->slug)) }}" class="v8-sector-item">
              <div class="v8-sector-item-img">
                <img src="{{ asset($indp->image_url ?: 'client-assets/images/placeholder.png') }}" alt="{{ $indp->name }}">
              </div>
              <div class="v8-sector-item-title">{{ Str::limit($indp->name, 35) }}</div>
              <div class="v8-sector-item-price">{{ number_format($indp->price, 0, ',', '.') }}₫</div>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 9. KHỐI GIỚI THIỆU & UY TÍN WINLINE -->
<section class="v8-about-section">
  <div class="v8-container">
    <div class="v8-about-box">
      <div class="v8-about-heading-col">
        <h2 class="v8-about-title">Winline cung cấp quạt điện và thiết bị thông gió</h2>
      </div>
      <div class="v8-about-content-col">
        <p class="v8-about-text">
          Từ quạt dùng trong gia đình đến quạt cho kho xưởng và công trình, Winline tập hợp sản phẩm của nhiều thương hiệu để khách dễ tìm đúng loại hàng. Thông tin sản phẩm, giá và cách giao được trình bày rõ trước khi đặt; đơn mua số lượng có thể nhận báo giá và tài liệu sản phẩm phù hợp.
        </p>
        <a href="{{ route('client.about') }}" class="v8-about-link">Tìm hiểu về Winline →</a>
      </div>
    </div>
  </div>
</section>

@endsection


