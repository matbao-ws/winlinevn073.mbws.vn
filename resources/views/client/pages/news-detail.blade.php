@extends('client.layouts.app')

@section('title', ($post->title ?? 'Chi tiết bài viết') . ' | Tin tức Winline.vn')

@push('styles')
<style>
@import url("https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600;700&display=swap");

:root {
  --navy-950:#004e7d;
  --navy-800:#004e7d;
  --navy-700:#1f6690;
  --navy-100: #e6eef3;
  --paper: #f8fafc;
  --white: #ffffff;
  --ink: #1e293b;
  --ink-soft: #64748b;
  --line: #e2e8f0;
  --orange: #d41e3d;
  --orange-dark: #a71830;
  --orange-100: #f4e6e9;
  --green: #1e8a5f;
  --radius: 8px;
  --shadow: 0 4px 20px rgba(13,31,51,.07);
}
* { box-sizing: border-box; }
html, body { margin: 0; padding: 0; overflow-x: hidden; max-width: 100%; }
body {
  font-family: "Be Vietnam Pro", system-ui, sans-serif;
  color: var(--ink);
  background: var(--paper);
  font-size: 15px;
  line-height: 1.7;
}
a { color: inherit; text-decoration: none; }
img { max-width: 100%; display: block; }
button { font-family: inherit; cursor: pointer; }

/* Breadcrumb */
.breadcrumb { max-width: 1240px; margin: 0 auto; padding: 14px 20px 0; font-size: 12.5px; color: var(--ink-soft); }
.breadcrumb a:hover { color: var(--navy-800); text-decoration: underline; }

/* Article Container Layout (3-Column / 2-Column Responsive) */
.article-detail-layout {
  max-width: 1240px;
  margin: 20px auto 60px;
  padding: 0 20px;
  display: grid;
  grid-template-columns: 260px 1fr;
  gap: 28px;
  align-items: start;
}
@media (max-width: 960px) {
  .article-detail-layout {
    grid-template-columns: 1fr;
    gap: 24px;
  }
}

/* Left Sidebar Menu (Matching Winline Old Website Layout) */
.article-left-sidebar {
  display: flex;
  flex-direction: column;
  gap: 20px;
  position: sticky;
  top: 20px;
}
@media (max-width: 960px) {
  .article-left-sidebar {
    position: static;
  }
}
.sidebar-box {
  background: #ffffff;
  border: 1px solid var(--line);
  border-radius: 8px;
  padding: 16px 18px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.sidebar-box-title {
  font-size: 13.5px;
  font-weight: 800;
  text-transform: uppercase;
  color: var(--navy-950);
  letter-spacing: 0.04em;
  padding-left: 8px;
  border-left: 3px solid var(--navy-800);
  margin: 0 0 12px;
}
.sidebar-cat-list {
  list-style: none;
  margin: 0;
  padding: 0;
}
.sidebar-cat-list li {
  border-bottom: 1px dashed #f1f5f9;
}
.sidebar-cat-list li:last-child {
  border-bottom: none;
}
.sidebar-cat-list a {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 9px 4px;
  font-size: 13px;
  color: #334155;
  font-weight: 500;
  transition: all 0.15s ease;
}
.sidebar-cat-list a:hover {
  color: var(--navy-800);
  padding-left: 6px;
  font-weight: 600;
}
.sidebar-cat-list a.active {
  color: var(--orange);
  font-weight: 700;
}

/* Related Article items in Left Sidebar */
.side-rel-item {
  display: flex;
  flex-direction: column;
  gap: 3px;
  padding: 8px 0;
  border-bottom: 1px solid #f1f5f9;
}
.side-rel-item:last-child { border-bottom: none; }
.side-rel-title {
  font-size: 12.5px;
  font-weight: 600;
  color: var(--navy-950);
  line-height: 1.35;
}
.side-rel-title a:hover { color: var(--navy-800); }
.side-rel-date { font-size: 11px; color: #94a3b8; }

/* Main Article Content Card */
.article-main-card {
  background: #ffffff;
  border: 1px solid var(--line);
  border-radius: 10px;
  padding: 32px 36px;
  box-shadow: var(--shadow);
  min-width: 0;
}
@media (max-width: 640px) {
  .article-main-card {
    padding: 20px 16px;
  }
}

.article-title {
  font-size: 24px;
  font-weight: 800;
  color: var(--navy-950);
  line-height: 1.35;
  margin: 0 0 10px;
}
.article-meta-line {
  font-size: 12.5px;
  color: #94a3b8;
  margin-bottom: 18px;
  padding-bottom: 14px;
  border-bottom: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
}
.article-meta-line span i { color: var(--navy-800); margin-right: 4px; }

/* IN-ARTICLE BEST-SELLING PRODUCTS SHOWCASE (RED BOX MATCHING WINLINE.VN) */
.in-article-showcase-box {
  background: #ffffff;
  border: 1.5px solid #dbe4ee;
  border-radius: 8px;
  padding: 16px 18px;
  margin: 24px 0 28px;
  position: relative;
  box-shadow: 0 4px 14px rgba(7,34,66,0.05);
}
.showcase-header-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 14px;
  padding-bottom: 8px;
  border-bottom: 2px solid #eef2f6;
  flex-wrap: wrap;
  gap: 8px;
}
.showcase-heading {
  font-size: 15px;
  font-weight: 800;
  color: var(--orange);
  margin: 0;
  display: flex;
  align-items: center;
  gap: 6px;
}
.showcase-view-all {
  font-size: 12px;
  font-weight: 700;
  color: var(--navy-800);
  text-decoration: underline;
}

/* Horizontal Product Slider Track */
.showcase-slider-wrap {
  position: relative;
}
.showcase-slider-track {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
}
@media (max-width: 820px) {
  .showcase-slider-track {
    grid-template-columns: repeat(2, 1fr);
  }
}
@media (max-width: 480px) {
  .showcase-slider-track {
    grid-template-columns: 1fr;
  }
}

.sc-product-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  padding: 12px;
  display: flex;
  flex-direction: column;
  transition: all 0.2s ease;
  text-decoration: none;
}
.sc-product-card:hover {
  transform: translateY(-3px);
  border-color: var(--navy-800);
  box-shadow: 0 6px 18px rgba(0,96,182,0.12);
}
.sc-img-wrap {
  width: 100%;
  aspect-ratio: 1/1;
  background: #fdfdfd;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 8px;
  overflow: hidden;
}
.sc-img {
  max-width: 90%;
  max-height: 90%;
  object-fit: contain;
  transition: transform 0.25s ease;
}
.sc-product-card:hover .sc-img {
  transform: scale(1.05);
}
.sc-title {
  font-size: 12px;
  font-weight: 600;
  color: #1e293b;
  line-height: 1.35;
  height: 48px;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  margin-bottom: 6px;
}
.sc-brand-price {
  margin-top: auto;
  padding-top: 6px;
  border-top: 1px dashed #f1f5f9;
}
.sc-brand {
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
  color: var(--navy-800);
  margin-right: 4px;
}
.sc-price {
  font-family: 'IBM Plex Mono', monospace;
  font-size: 13.5px;
  font-weight: 800;
  color: var(--orange);
}
.sc-stars {
  font-size: 11px;
  color: #f59e0b;
  margin-top: 4px;
}

/* Article Body Typography */
.article-body h2 {
  font-size: 19px;
  font-weight: 800;
  color: var(--navy-950);
  margin: 28px 0 12px;
  padding-bottom: 6px;
  border-bottom: 1.5px solid #e2e8f0;
}
.article-body h3 {
  font-size: 16px;
  font-weight: 700;
  color: var(--navy-950);
  margin: 20px 0 8px;
}
.article-body p {
  margin: 0 0 16px;
  color: #334155;
  font-size: 14.5px;
  line-height: 1.7;
}
.article-body ul, .article-body ol {
  margin: 0 0 18px 20px;
  padding-left: 0;
  font-size: 14px;
}
.article-body li {
  margin-bottom: 6px;
  color: #334155;
}

/* Callout Box */
.callout-box {
  display: flex;
  gap: 14px;
  padding: 16px 18px;
  border-radius: 6px;
  margin: 20px 0;
}
.info-callout {
  background: #eff6ff;
  border: 1px solid #bfdbfe;
  border-left: 4px solid #004e7d;
}
.callout-icon { font-size: 20px; color: #004e7d; flex-shrink: 0; margin-top: 2px; }
.callout-content h4 { font-size: 14px; font-weight: 700; margin: 0 0 4px; color: var(--navy-950); }
.callout-content p { font-size: 13px; margin: 0; color: #475569; }
.inline-cta-link { color: var(--navy-800); font-weight: 700; text-decoration: underline; }

/* Formula Card */
.formula-card {
  background: linear-gradient(135deg, #004e7d 0%, #1f6690 100%);
  color: #ffffff;
  border-radius: 8px;
  padding: 20px 22px;
  margin: 20px 0;
}
.formula-main {
  font-family: 'IBM Plex Mono', monospace;
  font-size: 20px;
  font-weight: 700;
  color: #facc15;
  text-align: center;
  padding: 8px 0 12px;
  border-bottom: 1px solid rgba(255,255,255,0.15);
  margin-bottom: 12px;
}
.formula-legend ul { list-style: none; margin: 0; padding: 0; font-size: 13px; }
.formula-legend li { color: #e2e8f0; margin-bottom: 4px; }
.formula-legend code { background: rgba(255,255,255,0.15); padding: 2px 6px; border-radius: 4px; color: #facc15; font-family: 'IBM Plex Mono', monospace; }

/* Table responsive */
.table-responsive { overflow-x: auto; margin: 20px 0; }
.article-table { width: 100%; border-collapse: collapse; font-size: 13px; background: #fff; border: 1px solid var(--line); border-radius: 6px; overflow: hidden; }
.article-table th { background: #f1f5f9; color: var(--navy-950); font-weight: 700; text-align: left; padding: 10px 14px; border-bottom: 2px solid var(--line); }
.article-table td { padding: 10px 14px; border-bottom: 1px solid #f1f5f9; color: #334155; }
.highlight-badge { display: inline-block; background: #dbeafe; color: #1e40af; font-weight: 700; font-size: 11.5px; padding: 2px 6px; border-radius: 4px; }
</style>
@endpush

@section('content')
<div class="breadcrumb" id="artBreadcrumb">
  <a href="{{ route('client.home') }}">Trang chủ</a> › 
  <a href="{{ route('client.news') }}">Tin tức & Cẩm nang</a> › 
  @if($post->category)
    <a href="{{ route('client.news', ['category' => $post->category->canonicalSlug()]) }}">{{ $post->category->name }}</a> › 
  @endif
  <span>{{ Str::limit($post->title, 50) }}</span>
</div>

<main class="article-detail-layout">
  <!-- Left Sidebar (Matching Winline.vn Old Architecture) -->
  <aside class="article-left-sidebar">
    <div class="sidebar-box">
      <h3 class="sidebar-box-title">Danh mục bài viết</h3>
      <ul class="sidebar-cat-list">
        <li><a href="{{ route('client.about') }}">Giới thiệu công ty <i class="fas fa-angle-right"></i></a></li>
        <li><a href="{{ route('client.brands') }}">Chọn theo thương hiệu <i class="fas fa-angle-right"></i></a></li>
        <li><a href="{{ route('client.solutions') }}">Chọn theo nhu cầu xưởng <i class="fas fa-angle-right"></i></a></li>
        <li><a href="{{ route('client.news') }}" class="active">Tư vấn chọn mua quạt <i class="fas fa-angle-right"></i></a></li>
        <li><a href="{{ route('client.contact') }}">Hỗ trợ & Bảo hành <i class="fas fa-angle-right"></i></a></li>
      </ul>
    </div>

    <div class="sidebar-box">
      <h3 class="sidebar-box-title">Bài viết liên quan</h3>
      <div id="sideRelatedList">
        @forelse($relatedPosts as $rel)
          <div class="side-rel-item" style="margin-bottom:12px; padding-bottom:10px; border-bottom:1px solid #f1f5f9;">
            <div class="side-rel-title"><a href="{{ route('client.news.detail', ['slug' => $rel->canonicalSlug()]) }}">{{ $rel->title }}</a></div>
            <div class="side-rel-date" style="margin-top:4px; font-size:11px; color:#94a3b8;"><i class="far fa-calendar-alt"></i> {{ $rel->published_at ? $rel->published_at->format('d/m/Y') : date('d/m/Y') }}</div>
          </div>
        @empty
          <p style="font-size:13px; color:#94a3b8;">Chưa có bài viết liên quan.</p>
        @endforelse
      </div>
    </div>

    <!-- Quick Contact Hotline -->
    <div class="sidebar-box" style="background: linear-gradient(135deg, #004e7d 0%, #004e7d 100%); color:#fff; border:none; text-align:center; padding:18px;">
      <i class="fas fa-phone-volume" style="font-size:24px; color:#facc15; margin-bottom:8px;"></i>
      <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#dbe4ee;">Hotline tư vấn Winline</div>
      <a href="tel:0949761893" style="font-size:18px; font-weight:800; color:#fff; display:block; margin:4px 0 6px;">0949.761.893</a>
      <div style="font-size:11px; color:#dbe4ee;">Báo giá sỉ & Dự án M&E</div>
    </div>
  </aside>

  <!-- Main Article Body -->
  <article class="article-main-card">
    <h1 class="article-title">{{ $post->title }}</h1>
    
    <div class="article-meta-line">
      <span><i class="far fa-user"></i> <strong>Ban Kỹ Thuật Winline</strong></span>
      <span><i class="far fa-calendar-alt"></i> {{ $post->published_at ? $post->published_at->format('d/m/Y') : date('d/m/Y') }}</span>
      <span><i class="far fa-folder"></i> {{ $post->category?->name ?? 'Tư vấn kỹ thuật' }}</span>
    </div>

    <div class="article-body">
      @if($post->summary)
        <div class="callout-box info-callout" style="margin-bottom:24px;">
          <div class="callout-icon"><i class="fas fa-info-circle"></i></div>
          <div class="callout-content">
            <h4 style="margin:0 0 6px; font-weight:700;">Tóm tắt cẩm nang</h4>
            <p style="margin:0; font-size:13.5px; line-height:1.6;">{{ $post->summary }}</p>
          </div>
        </div>
      @endif

      @if($post->image_url)
        <div style="margin:20px 0; text-align:center;">
          <img src="{{ str_starts_with($post->image_url, 'http') ? $post->image_url : asset($post->image_url) }}" alt="{{ $post->title }}" style="max-height:420px; width:auto; margin:0 auto; border-radius:8px;">
        </div>
      @endif

      <div class="article-rich-text" style="line-height:1.8; color:#334155;">
        {!! app(\App\Services\ContentRenderService::class)->render($post->content) !!}
      </div>

      <!-- Quick CTA inside article -->
      <div class="in-article-showcase-box" style="margin-top:32px;">
        <div class="showcase-header-row">
          <h3 class="showcase-heading"><i class="fas fa-fire"></i> Cần tư vấn chọn quạt & khảo sát dự án trực tiếp?</h3>
          <a href="{{ route('client.contact') }}" class="showcase-view-all">Liên hệ Winline ngay →</a>
        </div>
        <p style="margin:8px 0 0; font-size:13.5px; color:#475569;">
          Đội ngũ kỹ sư HVAC Winline hỗ trợ tính toán công suất, lập dự toán chi tiết và cung cấp đầy đủ hồ sơ năng lực, CO, CQ cho các nhà thầu cơ điện và chủ đầu tư trên toàn quốc.
        </p>
      </div>
    </div>
  </article>
</main>
@endsection


