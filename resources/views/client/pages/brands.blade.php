@extends('client.layouts.app')

@section('title', 'Hệ thống thương hiệu quạt điện & thiết bị thông gió chính hãng | Winline.vn')

@push('styles')
<style>
  .brand-hub-page {
    background: #f8fafc;
    min-height: 80vh;
    padding-bottom: 60px;
  }
  .bh-container {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 20px;
  }
  .bh-breadcrumb {
    padding: 14px 0;
    font-size: 13px;
    color: var(--ink-soft, #64748b);
  }
  .bh-breadcrumb a {
    color: inherit;
    text-decoration: none;
  }
  .bh-breadcrumb a:hover {
    color: var(--brand-blue, #004e7d);
    text-decoration: underline;
  }
  .bh-hero {
    background: linear-gradient(135deg, #00354f 0%, #004e7d 100%);
    border-radius: 12px;
    padding: 36px 32px;
    color: #ffffff;
    margin-bottom: 32px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 53, 79, 0.12);
  }
  .bh-hero::after {
    content: '';
    position: absolute;
    right: -40px;
    top: -40px;
    width: 220px;
    height: 220px;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
  }
  .bh-hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #f8fafc;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 20px;
    margin-bottom: 12px;
  }
  .bh-hero h1 {
    font-size: 28px;
    font-weight: 800;
    line-height: 1.3;
    margin: 0 0 10px;
    color: #ffffff;
  }
  .bh-hero p {
    font-size: 14.5px;
    color: rgba(255, 255, 255, 0.9);
    max-width: 820px;
    line-height: 1.6;
    margin: 0;
  }
  .bh-section-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 20px;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 10px;
  }
  .bh-section-title {
    font-size: 20px;
    font-weight: 800;
    color: var(--navy-950, #00354f);
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
  }
  .bh-section-subtitle {
    font-size: 13px;
    color: var(--ink-soft, #64748b);
    margin: 4px 0 0;
  }

  /* 4 Pillars Strategic Grid */
  .bh-pillars-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 40px;
  }
  @media (max-width: 992px) {
    .bh-pillars-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  @media (max-width: 560px) {
    .bh-pillars-grid {
      grid-template-columns: 1fr;
    }
  }
  .bh-pillar-card {
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    padding: 20px 18px;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 53, 79, 0.04);
    position: relative;
  }
  .bh-pillar-card:hover {
    border-color: var(--brand-blue, #004e7d);
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0, 78, 125, 0.12);
  }
  .bh-pillar-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: #eef4fb;
    color: var(--brand-blue, #004e7d);
    font-size: 10.5px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 4px;
    text-transform: uppercase;
  }
  .bh-pillar-logo-wrap {
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
    background: #f8fafc;
    border-radius: 6px;
    padding: 8px;
  }
  .bh-pillar-logo-wrap img {
    max-height: 48px;
    max-width: 140px;
    object-fit: contain;
  }
  .bh-pillar-name {
    font-size: 17px;
    font-weight: 800;
    color: var(--navy-950, #00354f);
    margin: 0 0 6px;
  }
  .bh-pillar-tagline {
    font-size: 12px;
    font-weight: 600;
    color: var(--brand-blue, #004e7d);
    margin-bottom: 8px;
    line-height: 1.4;
  }
  .bh-pillar-desc {
    font-size: 12.5px;
    color: var(--ink-soft, #5c6773);
    line-height: 1.5;
    margin-bottom: 14px;
    flex: 1;
  }
  .bh-pillar-features {
    list-style: none;
    padding: 0;
    margin: 0 0 16px;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
  }
  .bh-pillar-feature-tag {
    background: #f1f5f9;
    color: #334155;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 4px;
  }
  .bh-pillar-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12.5px;
    font-weight: 700;
    color: var(--brand-blue, #004e7d);
    padding-top: 12px;
    border-top: 1px solid #f1f5f9;
    transition: color 0.15s ease;
  }
  .bh-pillar-card:hover .bh-pillar-btn {
    color: var(--red-cta, #cb2027);
  }

  /* All Brands Grid */
  .bh-all-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 40px;
  }
  @media (max-width: 992px) {
    .bh-all-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }
  @media (max-width: 680px) {
    .bh-all-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  @media (max-width: 440px) {
    .bh-all-grid {
      grid-template-columns: 1fr;
    }
  }
  .bh-brand-tile {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
    transition: all 0.15s ease;
  }
  .bh-brand-tile:hover {
    border-color: var(--brand-blue, #004e7d);
    box-shadow: 0 4px 12px rgba(0, 78, 125, 0.08);
    transform: translateY(-2px);
  }
  .bh-tile-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
  }
  .bh-tile-count {
    font-size: 11px;
    font-weight: 700;
    color: var(--brand-blue, #004e7d);
    background: #eef4fb;
    padding: 2px 7px;
    border-radius: 12px;
  }
  .bh-tile-origin {
    font-size: 10.5px;
    color: #64748b;
    font-weight: 600;
  }
  .bh-tile-logo {
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    background: #f8fafc;
    border-radius: 6px;
    padding: 6px;
  }
  .bh-tile-logo img {
    max-height: 40px;
    max-width: 120px;
    object-fit: contain;
  }
  .bh-tile-name {
    font-size: 15px;
    font-weight: 700;
    color: var(--navy-950, #00354f);
    margin: 0 0 4px;
    text-align: center;
  }
  .bh-brand-tile:hover .bh-tile-name {
    color: var(--brand-blue, #004e7d);
  }
  .bh-tile-desc {
    font-size: 11.5px;
    color: var(--ink-soft, #5c6773);
    line-height: 1.4;
    text-align: center;
    margin: 0 0 10px;
    flex: 1;
  }
  .bh-tile-link {
    font-size: 12px;
    font-weight: 700;
    color: var(--brand-blue, #004e7d);
    text-align: center;
    padding-top: 8px;
    border-top: 1px solid #f1f5f9;
  }

  /* B2B Assurance Box */
  .bh-assurance-box {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 28px 24px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
  }
  .bh-assurance-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
  }
  @media (max-width: 860px) {
    .bh-assurance-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  @media (max-width: 500px) {
    .bh-assurance-grid {
      grid-template-columns: 1fr;
    }
  }
  .bh-assurance-item {
    display: flex;
    gap: 12px;
  }
  .bh-assurance-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #eef4fb;
    color: var(--brand-blue, #004e7d);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
  }
  .bh-assurance-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--navy-950, #00354f);
    margin: 0 0 4px;
  }
  .bh-assurance-desc {
    font-size: 12px;
    color: var(--ink-soft, #5c6773);
    line-height: 1.45;
    margin: 0;
  }
  .bh-cta-banner {
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
  }
  .bh-cta-text {
    font-size: 13.5px;
    color: var(--navy-950, #00354f);
    margin: 0;
  }
  .bh-cta-actions {
    display: flex;
    gap: 10px;
  }
  .bh-btn-phone {
    background: var(--brand-blue, #004e7d);
    color: #ffffff !important;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .bh-btn-phone:hover {
    background: var(--navy-950, #00354f);
  }
  .bh-btn-zalo {
    background: #0068ff;
    color: #ffffff !important;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .bh-btn-zalo:hover {
    opacity: 0.9;
  }
</style>
@endpush

@php
  $brandMeta = [
    'vinawind' => [
      'tagline' => 'Thương hiệu quốc dân hơn 50 năm — Điện Cơ Thống Nhất',
      'origin' => 'Việt Nam',
      'highlight' => 'Quạt trần, quạt cây, quạt treo tường, quạt sàn công trình với giá thành kinh tế nhất, độ bền vượt trội.',
      'warranties' => ['Bảo hành 12 tháng', 'Linh kiện sẵn có', 'Phân phối cấp 1'],
    ],
    'komasu' => [
      'tagline' => 'Dẫn đầu phân khúc quạt công nghiệp motor 100% dây đồng',
      'origin' => 'Việt Nam / Hàn Quốc',
      'highlight' => 'Lồng mạ crom siêu bền, sải cánh 500 – 1000mm, động cơ tải nặng cực đại cho nhà xưởng & nhà hàng.',
      'warranties' => ['Bảo hành 12 tháng', 'Motor đồng 100%', 'Đầy đủ CO/CQ'],
    ],
    'chinghai' => [
      'tagline' => 'Chuyên gia quạt công nghiệp nặng kết cấu gang đúc & cánh nhôm',
      'origin' => 'Đài Loan',
      'highlight' => 'Thân đế gang đúc chống rung lắc, cánh đúc hợp kim nhôm chịu môi trường bụi bẩn & nhiệt độ cao.',
      'warranties' => ['Bảo hành 12 tháng', 'Cánh nhôm đúc', 'Chịu tải công nghiệp'],
    ],
    'nanyoo' => [
      'tagline' => 'Thương hiệu quạt cắt gió & giải pháp cấp khí tươi hàng đầu',
      'origin' => 'Tiêu chuẩn Quốc tế',
      'highlight' => 'Chuyên quạt cắt gió chắn bụi ngăn nhiệt, quạt thông gió ly tâm âm trần cho trung tâm thương mại & văn phòng.',
      'warranties' => ['Bảo hành 24 tháng', 'Đạt chuẩn ISO/CE', 'Động cơ siêu êm'],
    ],
    'panasonic' => [
      'tagline' => 'Đỉnh cao quạt trần DC & thiết bị thông gió thông minh',
      'origin' => 'Nhật Bản',
      'highlight' => 'Động cơ DC tiết kiệm điện, công nghệ Econavi cảm biến thông minh, độ an toàn và êm ái hàng đầu.',
      'warranties' => ['Bảo hành 12 - 24 tháng', 'Động cơ DC Inverter', 'An toàn 5 cấp'],
    ],
    'nedfon' => [
      'tagline' => 'Giải pháp quạt thông gió âm trần & quạt hút nối ống cao cấp',
      'origin' => 'Châu Âu / Quốc tế',
      'highlight' => 'Chuyên quạt cabinet tiêu âm, quạt hút thông gió trung tâm cho biệt thự, khách sạn, bệnh viện & phòng sạch.',
      'warranties' => ['Bảo hành 24 tháng', 'Độ ồn cực thấp', 'Chứng chỉ CQ/CO'],
    ],
    'deton' => [
      'tagline' => 'Quạt hút thông gió vuông & quạt xách tay công nghiệp',
      'origin' => 'Quốc tế',
      'highlight' => 'Đa dạng kích thước quạt vuông chớp che mưa, quạt ly tâm hút khói bếp và ống gió mềm chuyên dụng.',
      'warranties' => ['Bảo hành 12 tháng', 'Motor dây đồng', 'Lưu lượng cực lớn'],
    ],
    'dasin' => [
      'tagline' => 'Quạt đứng, quạt sàn công nghiệp chân quỳ cao cấp',
      'origin' => 'Đài Loan',
      'highlight' => 'Trục đỡ vòng bi Nhật Bản kín bụi, motor chống cháy tự ngắt TC, vỏ sơn tĩnh điện cao cấp.',
      'warranties' => ['Bảo hành 24 tháng', 'Vòng bi Nhật Bản', 'Chống bụi tuyệt đối'],
    ],
    'kdk' => [
      'tagline' => 'Thương hiệu quạt thông gió Nhật Bản thành lập từ năm 1909',
      'origin' => 'Nhật Bản',
      'highlight' => 'Tiên phong công nghệ thông gió thế giới, độ bền bỉ hàng chục năm và hiệu suất lưu lượng vượt trội.',
      'warranties' => ['Bảo hành 24 tháng', 'Tiêu chuẩn Nhật Bản', 'Động cơ bền bỉ'],
    ],
    'mitsubishi' => [
      'tagline' => 'Quạt điện gia dụng & quạt trần cao cấp Mitsubishi Electric',
      'origin' => 'Nhật Bản / Thái Lan',
      'highlight' => 'Thiết kế tinh tế sang trọng, vận hành êm ái tiết kiệm điện, công nghệ bảo vệ an toàn 2 lớp.',
      'warranties' => ['Bảo hành 12 tháng', 'Mô tơ vỏ kín', 'Tiết kiệm năng lượng'],
    ],
    'tico' => [
      'tagline' => 'Quạt thông gió & quạt dân dụng Việt Nam giá rẻ',
      'origin' => 'Việt Nam',
      'highlight' => 'Giải pháp thông gió dân dụng và nhà ở tiết kiệm chi phí, dễ dàng lắp đặt và bảo dưỡng.',
      'warranties' => ['Bảo hành 12 tháng', 'Giá rẻ quốc dân', 'Linh kiện có sẵn'],
    ],
    'hatari' => [
      'tagline' => 'Thương hiệu quạt điện hàng đầu xuất xứ Thái Lan',
      'origin' => 'Thái Lan',
      'highlight' => 'Quạt công nghiệp và gia đình chất lượng cao, cầu chì cảm biến nhiệt an toàn Thermal Fuse.',
      'warranties' => ['Bảo hành 12 - 36 tháng', 'Chuẩn TIS Thái Lan', 'Cầu chì Thermal Fuse'],
    ],
  ];

  $corePillarSlugs = ['vinawind', 'komasu', 'chinghai', 'nanyoo'];
  $coreBrands = $brands->filter(fn($b) => in_array($b->slug, $corePillarSlugs))->sortBy(fn($b) => array_search($b->slug, $corePillarSlugs));
@endphp

@section('content')
<div class="brand-hub-page">
  <div class="bh-container">
    {{-- Breadcrumb --}}
    <div class="bh-breadcrumb">
      <a href="{{ route('client.home') }}">Trang chủ</a> › <span>Thương hiệu</span>
    </div>

    {{-- Hero Intro --}}
    <section class="bh-hero">
      <div class="bh-hero-tag">
        <i class="fas fa-shield-halved"></i> Đối Tác Phân Phối Chính Hãng Cấp 1
      </div>
      <h1>Hệ thống thương hiệu quạt &amp; thiết bị thông gió chính hãng</h1>
      <p>
        Winline Việt Nam là tổng kho phân phối và đại lý cấp 1 các thương hiệu quạt công nghiệp, quạt dân dụng và hệ thống xử lý không khí hàng đầu trong nước &amp; quốc tế. Mọi sản phẩm xuất kho đều cam kết 100% chính hãng, đầy đủ chứng chỉ xuất xưởng, CQ/CO, hóa đơn VAT và chính sách giá chiết khấu dự án tốt nhất cho nhà thầu M&amp;E.
      </p>
    </section>

    {{-- Section 1: 4 Thương Hiệu Trọng Tâm Chiến Lược (Vinawind, Komasu, Chinghai, Nanyoo) --}}
    <section style="margin-bottom: 36px;">
      <div class="bh-section-head">
        <div>
          <h2 class="bh-section-title"><i class="fas fa-award" style="color:var(--brand-blue, #004e7d);"></i> 4 Thương Hiệu Chủ Lực Chiến Lược</h2>
          <p class="bh-section-subtitle">Bốn thương hiệu đối tác nòng cốt với doanh số hàng đầu, phụ tùng sẵn sàng và chính sách giá tốt nhất hệ thống</p>
        </div>
      </div>

      <div class="bh-pillars-grid">
        @foreach($coreBrands as $b)
          @php
            $meta = $brandMeta[$b->slug] ?? [
              'tagline' => 'Thương hiệu phân phối chính hãng tại Winline',
              'origin' => 'Chính hãng',
              'highlight' => 'Đầy đủ quạt công nghiệp và thông gió đạt chuẩn chất lượng cao.',
              'warranties' => ['Bảo hành chính hãng', 'CO/CQ đầy đủ'],
            ];
            $bUrl = url(app()->getLocale() . '/' . ($b->canonicalSlug(app()->getLocale()) ?: $b->slug));
          @endphp
          <a href="{{ $bUrl }}" class="bh-pillar-card">
            <span class="bh-pillar-badge">{{ $meta['origin'] }}</span>
            <div class="bh-pillar-logo-wrap">
              @if($b->image_url)
                <img src="{{ asset($b->image_url) }}" alt="{{ $b->getTranslation('name', app()->getLocale()) }}">
              @else
                <strong style="font-size: 20px; color: var(--navy-950);">{{ $b->getTranslation('name', app()->getLocale()) }}</strong>
              @endif
            </div>
            <h3 class="bh-pillar-name">{{ $b->getTranslation('name', app()->getLocale()) }}</h3>
            <div class="bh-pillar-tagline">{{ $meta['tagline'] }}</div>
            <div class="bh-pillar-desc">{{ $meta['highlight'] }}</div>
            <ul class="bh-pillar-features">
              @foreach($meta['warranties'] as $w)
                <li class="bh-pillar-feature-tag"><i class="fas fa-check" style="color:#10b981; font-size:10px;"></i> {{ $w }}</li>
              @endforeach
            </ul>
            <div class="bh-pillar-btn">
              <span>Xem {{ $b->products_count }} sản phẩm</span>
              <i class="fas fa-arrow-right"></i>
            </div>
          </a>
        @endforeach
      </div>
    </section>

    {{-- Section 2: Toàn Bộ Thương Hiệu Phân Phối (12 Hãng) --}}
    <section style="margin-bottom: 40px;">
      <div class="bh-section-head">
        <div>
          <h2 class="bh-section-title"><i class="fas fa-layer-group" style="color:var(--brand-blue, #004e7d);"></i> Tất Cả Thương Hiệu Đối Tác Phân Phối</h2>
          <p class="bh-section-subtitle">Đa dạng phân khúc từ dân dụng, thương mại đến quạt công nghiệp tải nặng &amp; hệ thống thông gió tòa nhà</p>
        </div>
      </div>

      <div class="bh-all-grid">
        @foreach($brands as $b)
          @php
            $meta = $brandMeta[$b->slug] ?? [
              'tagline' => 'Thương hiệu đối tác Winline',
              'origin' => 'Chính hãng',
              'highlight' => 'Thiết bị quạt và thông gió chất lượng cao.',
              'warranties' => ['Chính hãng 100%'],
            ];
            $bUrl = url(app()->getLocale() . '/' . ($b->canonicalSlug(app()->getLocale()) ?: $b->slug));
          @endphp
          <a href="{{ $bUrl }}" class="bh-brand-tile">
            <div class="bh-tile-top">
              <span class="bh-tile-origin"><i class="fas fa-location-dot" style="font-size:10px;"></i> {{ $meta['origin'] }}</span>
              <span class="bh-tile-count">{{ $b->products_count }} SP</span>
            </div>
            <div class="bh-tile-logo">
              @if($b->image_url)
                <img src="{{ asset($b->image_url) }}" alt="{{ $b->getTranslation('name', app()->getLocale()) }}">
              @else
                <strong style="color: var(--navy-950);">{{ $b->getTranslation('name', app()->getLocale()) }}</strong>
              @endif
            </div>
            <h4 class="bh-tile-name">{{ $b->getTranslation('name', app()->getLocale()) }}</h4>
            <p class="bh-tile-desc">{{ $meta['tagline'] }}</p>
            <div class="bh-tile-link">Xem sản phẩm →</div>
          </a>
        @endforeach
      </div>
    </section>

    {{-- Section 3: Cam Kết Nhà Phân Phối B2B & Quyền Lợi Doanh Nghiệp --}}
    <section class="bh-assurance-box">
      <div class="bh-assurance-grid">
        <div class="bh-assurance-item">
          <div class="bh-assurance-icon"><i class="fas fa-shield-alt"></i></div>
          <div>
            <h4 class="bh-assurance-title">100% Chính Hãng</h4>
            <p class="bh-assurance-desc">Cam kết bồi thường 200% giá trị nếu phát hiện hàng giả, hàng nhái hoặc linh kiện kém chất lượng.</p>
          </div>
        </div>

        <div class="bh-assurance-item">
          <div class="bh-assurance-icon"><i class="fas fa-file-invoice"></i></div>
          <div>
            <h4 class="bh-assurance-title">Hồ Sơ CO/CQ Đầy Đủ</h4>
            <p class="bh-assurance-desc">Cung cấp trọn bộ Catalog, chứng chỉ xuất xưởng, hóa đơn VAT 10% phục vụ nghiệm thu công trình.</p>
          </div>
        </div>

        <div class="bh-assurance-item">
          <div class="bh-assurance-icon"><i class="fas fa-percent"></i></div>
          <div>
            <h4 class="bh-assurance-title">Chiết Khấu Dự Án Tốt Nhất</h4>
            <p class="bh-assurance-desc">Mức giá đại lý cấp 1 cạnh tranh nhất cho nhà thầu M&amp;E, đơn hàng công trình và khách hàng mua số lượng lớn.</p>
          </div>
        </div>

        <div class="bh-assurance-item">
          <div class="bh-assurance-icon"><i class="fas fa-screwdriver-wrench"></i></div>
          <div>
            <h4 class="bh-assurance-title">Bảo Hành &amp; Linh Kiện</h4>
            <p class="bh-assurance-desc">Bảo hành 12 - 24 tháng theo tiêu chuẩn hãng, sẵn sàng linh kiện thay thế và hỗ trợ kỹ thuật tận nơi.</p>
          </div>
        </div>
      </div>

      <div class="bh-cta-banner">
        <p class="bh-cta-text">
          <strong><i class="fas fa-headset" style="color:var(--brand-blue, #004e7d); margin-right:4px;"></i> Bạn đang cần báo giá chiết khấu dự án cho thương hiệu cụ thể?</strong> Liên hệ ngay với kỹ sư tư vấn của Winline để nhận báo giá chi tiết trong 5 phút.
        </p>
        <div class="bh-cta-actions">
          <a href="tel:0949761893" class="bh-btn-phone"><i class="fas fa-phone-alt"></i> 0949.761.893</a>
          <a href="https://zalo.me/0949761893" target="_blank" rel="noopener" class="bh-btn-zalo"><i class="fas fa-comment-dots"></i> Chat Zalo</a>
        </div>
      </div>
    </section>
  </div>
</div>
@endsection
