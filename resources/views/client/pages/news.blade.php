@extends('client.layouts.app')

@section('title', 'Tin tức & Cẩm nang Kỹ thuật HVAC | Winline.vn')

@push('styles')
<style>
@import url("https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600&display=swap");

:root {
  --navy-950:#004e7d;
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
  --radius: 8px;
  --shadow: 0 2px 12px rgba(13,31,51,.08);
}
* { box-sizing: border-box; }
html, body { margin: 0; padding: 0; overflow-x: hidden; max-width: 100%; }
body {
  font-family: "Be Vietnam Pro", system-ui, sans-serif;
  color: var(--ink);
  background: var(--paper);
  font-size: 15px;
  line-height: 1.6;
}
a { color: inherit; text-decoration: none; }
img { max-width: 100%; display: block; }
button { font-family: inherit; cursor: pointer; }

/* Breadcrumb */
.breadcrumb { max-width: 1240px; margin: 0 auto; padding: 14px 20px 0; font-size: 12.5px; color: var(--ink-soft); }
.breadcrumb a:hover { color: var(--navy-800); text-decoration: underline; }

/* News Hero Header */
.news-hero {
  background: linear-gradient(135deg, #004e7d 0%, #004e7d 60%, #004e7d 100%);
  color: #ffffff;
  padding: 40px 20px 48px;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.news-hero::after {
  content: "";
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.12) 0%, transparent 60%);
  pointer-events: none;
}
.news-hero h1 {
  font-size: 30px;
  font-weight: 800;
  margin: 0 0 10px;
  letter-spacing: -0.02em;
}
.news-hero p {
  max-width: 720px;
  margin: 0 auto;
  font-size: 15px;
  color: #dbe4ee;
  line-height: 1.6;
}

/* Category Filter Bar */
.news-nav-wrap {
  background: #ffffff;
  border-bottom: 1px solid var(--line);
  position: sticky;
  top: 0;
  z-index: 20;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.news-nav-inner {
  max-width: 1240px;
  margin: 0 auto;
  padding: 0 20px;
  display: flex;
  gap: 8px;
  overflow-x: auto;
  white-space: nowrap;
}
.news-cat-btn {
  padding: 14px 18px;
  font-size: 13.5px;
  font-weight: 600;
  color: var(--ink-soft);
  border: none;
  background: none;
  border-bottom: 3px solid transparent;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}
.news-cat-btn:hover {
  color: var(--navy-800);
}
.news-cat-btn.active {
  color: var(--orange);
  border-bottom-color: var(--orange);
  font-weight: 700;
}

/* Main Layout Grid */
.news-layout {
  max-width: 1240px;
  margin: 28px auto 60px;
  padding: 0 20px;
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 32px;
  align-items: start;
}
@media (max-width: 960px) {
  .news-layout {
    grid-template-columns: 1fr;
    gap: 24px;
  }
}

/* Featured Article Card */
.featured-card {
  background: #ffffff;
  border: 1px solid var(--line);
  border-radius: 12px;
  overflow: hidden;
  box-shadow: var(--shadow);
  margin-bottom: 32px;
  display: grid;
  grid-template-columns: 1.1fr 1fr;
  transition: transform 0.2s, box-shadow 0.2s;
}
.featured-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(7,34,66,0.12);
}
@media (max-width: 768px) {
  .featured-card {
    grid-template-columns: 1fr;
  }
}
.fc-img {
  width: 100%;
  height: 100%;
  min-height: 260px;
  object-fit: cover;
}
.fc-body {
  padding: 28px 26px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.fc-badge {
  align-self: flex-start;
  background: var(--orange-100);
  color: var(--orange);
  font-size: 11.5px;
  font-weight: 700;
  text-transform: uppercase;
  padding: 4px 10px;
  border-radius: 20px;
  margin-bottom: 12px;
}
.fc-title {
  font-size: 20px;
  font-weight: 800;
  color: var(--navy-950);
  line-height: 1.35;
  margin: 0 0 12px;
}
.fc-title a:hover {
  color: var(--navy-800);
}
.fc-excerpt {
  font-size: 13.5px;
  color: var(--ink-soft);
  line-height: 1.6;
  margin-bottom: 16px;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.fc-meta {
  display: flex;
  align-items: center;
  gap: 14px;
  font-size: 12px;
  color: #94a3b8;
  margin-top: auto;
}
.fc-meta i { margin-right: 4px; }

/* Article Grid */
.article-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 22px;
}
@media (max-width: 640px) {
  .article-grid {
    grid-template-columns: 1fr;
  }
}
.art-card {
  background: #ffffff;
  border: 1px solid var(--line);
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(13,31,51,0.06);
  display: flex;
  flex-direction: column;
  transition: all 0.2s ease;
}
.art-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(7,34,66,0.12);
  border-color: #cbd5e1;
}
.art-thumb-wrap {
  width: 100%;
  aspect-ratio: 16/9;
  overflow: hidden;
  position: relative;
  background: #e2e8f0;
}
.art-thumb {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}
.art-card:hover .art-thumb {
  transform: scale(1.04);
}
.art-badge-tag {
  position: absolute;
  top: 12px;
  left: 12px;
  background: rgba(7, 34, 66, 0.85);
  backdrop-filter: blur(4px);
  color: #ffffff;
  font-size: 10.5px;
  font-weight: 700;
  text-transform: uppercase;
  padding: 3px 8px;
  border-radius: 4px;
}
.art-body {
  padding: 18px 18px 20px;
  display: flex;
  flex-direction: column;
  flex: 1;
}
.art-meta-row {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 11.5px;
  color: #94a3b8;
  margin-bottom: 8px;
}
.art-meta-row i { margin-right: 3px; }
.art-card-title {
  font-size: 15.5px;
  font-weight: 700;
  color: var(--navy-950);
  line-height: 1.4;
  margin: 0 0 10px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.art-card-title a:hover {
  color: var(--navy-800);
}
.art-card-desc {
  font-size: 13px;
  color: var(--ink-soft);
  line-height: 1.55;
  margin-bottom: 16px;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.art-card-footer {
  margin-top: auto;
  padding-top: 12px;
  border-top: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.art-read-btn {
  font-size: 12.5px;
  font-weight: 700;
  color: var(--navy-800);
  display: inline-flex;
  align-items: center;
  gap: 5px;
  transition: gap 0.15s;
}
.art-read-btn:hover {
  color: var(--orange);
  gap: 8px;
}

/* Sidebar Widgets */
.news-sidebar {
  display: flex;
  flex-direction: column;
  gap: 24px;
}
.widget-card {
  background: #ffffff;
  border: 1px solid var(--line);
  border-radius: 10px;
  padding: 20px;
  box-shadow: var(--shadow);
}
.widget-title {
  font-size: 15px;
  font-weight: 800;
  color: var(--navy-950);
  text-transform: uppercase;
  letter-spacing: 0.03em;
  margin: 0 0 16px;
  padding-bottom: 8px;
  border-bottom: 2px solid var(--navy-800);
  display: flex;
  align-items: center;
  gap: 8px;
}
.widget-title i { color: var(--navy-800); }

/* Sidebar Trending List */
.trend-list {
  display: flex;
  flex-direction: column;
  gap: 14px;
}
.trend-item {
  display: flex;
  gap: 12px;
  align-items: flex-start;
}
.trend-num {
  font-size: 16px;
  font-weight: 800;
  color: #cbd5e1;
  line-height: 1;
  width: 20px;
}
.trend-item:nth-child(1) .trend-num { color: var(--orange); }
.trend-item:nth-child(2) .trend-num { color: #f59e0b; }
.trend-item:nth-child(3) .trend-num { color: var(--navy-800); }
.trend-info { flex: 1; min-width: 0; }
.trend-title {
  font-size: 13px;
  font-weight: 600;
  color: var(--navy-950);
  line-height: 1.35;
  margin: 0 0 4px;
}
.trend-title a:hover { color: var(--navy-800); }
.trend-meta { font-size: 11px; color: #94a3b8; }

/* Promo Calculation Widget */
.calc-promo-widget {
  background: linear-gradient(135deg, #004e7d 0%, #004e7d 60%, #004e7d 100%);
  color: #ffffff;
  border-radius: 10px;
  padding: 24px 20px;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.calc-promo-widget h3 {
  font-size: 16px;
  font-weight: 800;
  margin: 0 0 8px;
}
.calc-promo-widget p {
  font-size: 12.5px;
  color: #dbe4ee;
  margin: 0 0 16px;
  line-height: 1.5;
}
.calc-btn-cta {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: var(--orange);
  color: #ffffff;
  font-size: 13px;
  font-weight: 700;
  padding: 10px 18px;
  border-radius: 6px;
  box-shadow: 0 4px 12px rgba(212,30,61,0.4);
  transition: transform 0.2s, background 0.2s;
}
.calc-btn-cta:hover {
  background: var(--orange-dark);
  transform: translateY(-2px);
}

/* Hotline Support Box */
.hotline-widget {
  background: #f8fafc;
  border: 1.5px dashed #cbd5e1;
  border-radius: 10px;
  padding: 18px;
  text-align: center;
}
.hw-phone {
  font-size: 20px;
  font-weight: 800;
  color: var(--orange);
  margin: 6px 0;
  display: block;
}
.hw-sub {
  font-size: 12px;
  color: var(--ink-soft);
}
</style>
@endpush

@section('content')
<div class="breadcrumb">
  <a href="{{ route('client.home') }}">Trang chủ</a> › <span>Tin tức & Cẩm nang Kỹ thuật HVAC</span>
</div>

<div class="news-hero">
  <h1>Tin tức & Cẩm nang Kỹ thuật HVAC</h1>
  <p>Tổng hợp kiến thức tính toán lưu lượng thông gió, cẩm nang chọn mua quạt công nghiệp, quy chuẩn PCCC và kinh nghiệm lắp đặt từ đội ngũ kỹ sư Winline Việt Nam.</p>
</div>

<div class="news-nav-wrap">
  <div class="news-nav-inner" id="newsCatTabs">
    <a href="{{ route('client.news') }}" class="news-cat-btn {{ empty($currentCategorySlug) ? 'active' : '' }}"><i class="fas fa-border-all"></i> Tất cả bài viết</a>
    @foreach($categories as $cat)
      <a href="{{ route('client.news', ['category' => $cat->canonicalSlug()]) }}" class="news-cat-btn {{ $currentCategorySlug === $cat->canonicalSlug() ? 'active' : '' }}"><i class="fas fa-layer-group"></i> {{ $cat->name }}</a>
    @endforeach
  </div>
</div>

<main class="news-layout">
  <div class="news-main-col">
    @if($posts->count() > 0)
      @php $firstPost = $posts->first(); @endphp
      <!-- Featured Top Article -->
      <article class="featured-card">
        <img src="{{ $firstPost->image_url ? (str_starts_with($firstPost->image_url, 'http') ? $firstPost->image_url : asset($firstPost->image_url)) : asset('client-assets/images/deton-lytam.jpg') }}" alt="{{ $firstPost->title }}" class="fc-img">
        <div class="fc-body">
          <div class="fc-badge">{{ $firstPost->category?->name ?? 'Tiêu chuẩn kỹ thuật HVAC' }}</div>
          <h2 class="fc-title">
            <a href="{{ route('client.news.detail', ['slug' => $firstPost->canonicalSlug()]) }}">{{ $firstPost->title }}</a>
          </h2>
          <p class="fc-excerpt">{{ $firstPost->summary ?: 'Công thức chuẩn và tài liệu kỹ thuật hướng dẫn tính toán lưu lượng thông gió cho các nhà xưởng cơ khí, may mặc...' }}</p>
          <div class="fc-meta">
            <span><i class="far fa-calendar-alt"></i> {{ $firstPost->published_at ? $firstPost->published_at->format('d/m/Y') : date('d/m/Y') }}</span>
            <span><i class="far fa-user"></i> Ban Kỹ thuật Winline</span>
          </div>
        </div>
      </article>

      <!-- Articles Grid -->
      <div class="article-grid" id="articlesGrid">
        @foreach($posts as $art)
          <article class="art-card">
            <div class="art-thumb-wrap">
              <img src="{{ $art->image_url ? (str_starts_with($art->image_url, 'http') ? $art->image_url : asset($art->image_url)) : asset('client-assets/images/air-cooler-18000.jpg') }}" alt="{{ $art->title }}" class="art-thumb" loading="lazy">
              <span class="art-badge-tag">{{ $art->category?->name ?? 'Kỹ thuật' }}</span>
            </div>
            <div class="art-body">
              <div class="art-meta-row">
                <span><i class="far fa-calendar-alt"></i> {{ $art->published_at ? $art->published_at->format('d/m/Y') : date('d/m/Y') }}</span>
              </div>
              <h3 class="art-card-title">
                <a href="{{ route('client.news.detail', ['slug' => $art->canonicalSlug()]) }}">{{ $art->title }}</a>
              </h3>
              <p class="art-card-desc">{{ Str::limit($art->summary, 120) }}</p>
              <div class="art-card-footer">
                <span style="font-size:11.5px; color:#64748b;"><i class="fas fa-user-edit"></i> Ban Kỹ thuật</span>
                <a href="{{ route('client.news.detail', ['slug' => $art->canonicalSlug()]) }}" class="art-read-btn">Đọc chi tiết <i class="fas fa-arrow-right"></i></a>
              </div>
            </div>
          </article>
        @endforeach
      </div>

      <div style="margin-top:24px;">
        {{ $posts->links() }}
      </div>
    @else
      <div style="text-align:center; padding:40px; background:#fff; border-radius:10px; color:#64748b;">
        Chưa có bài viết nào trong chuyên mục này.
      </div>
    @endif
  </div>

  <aside class="news-sidebar">
    <!-- Trending / Most Read Widget -->
    <div class="widget-card">
      <div class="widget-title"><i class="fas fa-fire" style="color:var(--orange);"></i> Bài viết mới nhất</div>
      <div class="trend-list" id="trendingList">
        @foreach($recentPosts as $idx => $recent)
          <div class="trend-item">
            <div class="trend-num">0{{ $idx + 1 }}</div>
            <div class="trend-info">
              <h4 class="trend-title">
                <a href="{{ route('client.news.detail', ['slug' => $recent->canonicalSlug()]) }}">{{ $recent->title }}</a>
              </h4>
              <div class="trend-meta">
                <span>{{ $recent->category?->name ?? 'HVAC' }}</span> · <span>{{ $recent->published_at ? $recent->published_at->format('d/m/Y') : date('d/m/Y') }}</span>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Sizing Tool Widget -->
    <div class="calc-promo-widget">
      <i class="fas fa-calculator" style="font-size:32px; color:#facc15; margin-bottom:12px; display:inline-block;"></i>
      <h3>Công cụ tính quạt HVAC Online</h3>
      <p>Nhập chiều dài, rộng, cao xưởng để tính toán tự động số lượng quạt thông gió và tấm màng nước Cooling Pad theo chuẩn TCVN.</p>
      <a href="{{ route('client.calculator') }}" class="calc-btn-cta"><i class="fas fa-bolt"></i> Dùng công cụ tính ngay</a>
    </div>

    <!-- Hotline Technical Widget -->
    <div class="hotline-widget">
      <i class="fas fa-headset" style="font-size:26px; color:var(--navy-800); margin-bottom:6px;"></i>
      <div style="font-weight:700; font-size:13px; color:var(--navy-950);">Cần kỹ sư khảo sát & tư vấn?</div>
      <a href="tel:0949761893" class="hw-phone"><i class="fas fa-phone-alt"></i> 0949.761.893</a>
      <div class="hw-sub">Hỗ trợ kỹ thuật M&E và báo giá dự án 24/7</div>
    </div>
  </aside>
</main>
@endsection

