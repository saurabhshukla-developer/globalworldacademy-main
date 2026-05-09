@extends('layouts.site')

@section('title', ($settings['site_name'] ?? 'Global World Academy') . ' – Tutorials')

@section('meta')
<meta name="description" content="Global World Academy tutorials and featured categories. This page is ready for WordPress content sync."/>
<meta name="keywords" content="Global World Academy tutorials, MPTET tutorials, featured categories, WordPress tutorials"/>
<meta name="robots" content="index, follow"/>
<link rel="canonical" href="{{ route('tutorials') }}"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="Tutorials – {{ $settings['site_name'] ?? 'Global World Academy' }}"/>
<meta property="og:description" content="Explore tutorials and featured categories from Global World Academy. Content will populate once WordPress integration is active."/>
<meta property="og:url" content="{{ route('tutorials') }}"/>
@endsection

@section('content')

<!-- <section class="tutorial-banner" aria-labelledby="tutorial-banner-heading">
  <div class="tutorial-banner-inner reveal">
    <span class="sec-label tutorial-banner-label">Global World Academy</span>
    <h1 id="tutorial-banner-heading">Tutorials</h1>
  </div>
</section> -->

<section class="courses" aria-labelledby="featured-categories-heading">
  <div class="section-head center" style="margin-top:80px;">
    <div>
      <span class="sec-label">Tutorials</span>
      <h2 class="sec-title" id="featured-categories-heading">Featured Categories</h2>
    </div>
  </div>

  <div class="courses-grid">
    @forelse($featuredCategories as $category)
      <article class="course-card reveal tutorial-card" style="cursor:auto; display:flex; flex-direction:column;">
        <div class="course-thumb ct{{ ($loop->index % 6) + 1 }}">
          <span style="font-size:42px;">🗂️</span>
        </div>
        <div class="course-body" style="flex-grow:1; display:flex; flex-direction:column;">
          {{-- <span class="course-exam-tag">Featured</span> --}}
          <div class="course-name">{{ ucfirst($category['name']) }}</div>
        </div>
        <div class="tutorial-footer">
          @if(! empty($category['link']) && $category['link'] !== '#')
            <a href="{{ $category['link'] }}" target="_blank" rel="noopener" class="read-more-btn">Read More →</a>
          @endif
        </div>
      </article>
    @empty
      <div class="course-card placeholder reveal" style="grid-column: 1 / -1;">
        <div class="placeholder-icon">📂</div>
        <div class="placeholder-text">No featured categories have been selected yet. Add them from the admin panel to populate this section.</div>
      </div>
    @endforelse
  </div>
</section>

<section class="blog-posts" aria-labelledby="blog-posts-heading">
  <div class="section-head center">
    <span class="sec-label">Tutorials</span>
    <h2 class="sec-title" id="blog-posts-heading">Latest Tutorials</h2>
    <p class="sec-desc">Fresh learning guides from Global World Academy.</p>
  </div>

  <div class="courses-grid">
    @forelse($blogPosts as $post)
      <article class="course-card reveal blog-card">
        <a href="{{ $post['link'] }}" target="_blank" rel="noopener" class="blog-thumb" aria-label="Read {{ $post['title'] }}">
          @if(! empty($post['image']))
            <img src="{{ $post['image'] }}" alt="{{ $post['image_alt'] }}" loading="lazy"/>
          @else
            <div class="blog-thumb-fallback ct{{ ($loop->index % 6) + 1 }}">
              <span>{{ mb_substr($post['title'], 0, 1) }}</span>
            </div>
          @endif
        </a>
        <div class="course-body blog-body">
          <span class="course-exam-tag">Blog</span>
          <h3 class="course-name blog-title">{{ $post['title'] }}</h3>
          <p class="course-desc blog-excerpt">{{ $post['excerpt'] }}</p>
        </div>
        <div class="tutorial-footer">
          <a href="{{ $post['link'] }}" target="_blank" rel="noopener" class="read-more-btn">Read More &rarr;</a>
        </div>
      </article>
    @empty
      <div class="course-card placeholder reveal" style="grid-column: 1 / -1;">
        <div class="placeholder-icon">📚</div>
        <div class="placeholder-text">No tutorials are available right now. Please check back later.</div>
      </div>
    @endforelse
  </div>

  <div class="tutorials-all-posts">
    <a href="https://globalworldacademy.com" target="_blank" rel="noopener" class="btn btn-blue">
      Check All Tutorials &rarr;
    </a>
  </div>
</section>

@push('styles')
<style>
.tutorial-banner {
  min-height: 360px;
  padding-top: 150px;
  padding-bottom: 72px;
  display: flex;
  align-items: flex-end;
  background:
    linear-gradient(135deg, rgba(11,45,94,.94) 0%, rgba(17,85,204,.84) 56%, rgba(26,143,60,.76) 100%),
    linear-gradient(90deg, rgba(255,255,255,.12) 1px, transparent 1px),
    linear-gradient(0deg, rgba(255,255,255,.1) 1px, transparent 1px);
  background-size: auto, 44px 44px, 44px 44px;
  color: #fff;
  overflow: hidden;
}
.tutorial-banner-inner {
  width: min(1180px, 100%);
}
.tutorial-banner-label {
  background: rgba(255,255,255,.16);
  color: #fff;
}
.tutorial-banner h1 {
  max-width: 820px;
  font-size: clamp(46px, 7vw, 84px);
  font-weight: 800;
  line-height: 1;
  color: #fff;
}
.tutorial-card {
  transition: all 0.3s ease;
  border: 1px solid rgba(17, 85, 204, 0.08);
}
.tutorial-card:hover {
  border-color: rgba(17, 85, 204, 0.2);
  box-shadow: 0 12px 32px rgba(22, 47, 105, 0.1);
  transform: translateY(-4px);
}
.tutorial-footer {
  border-top: 1px solid rgba(17, 85, 204, 0.08);
  margin-top: auto;
  margin-left: 0;
}
.read-more-btn {
  display: block;
  color: var(--blue);
  font-size: 14px;
  font-weight: 600;
  text-decoration: none;
  padding: 20px;
  border-radius: 6px;
  transition: all 0.2s ease;
}
.read-more-btn:hover {
  background: rgba(17, 85, 204, 0.08);
  gap: 10px;
}
.blog-card {
  cursor: auto;
}
.blog-thumb {
  height: 190px;
  display: block;
  overflow: hidden;
  background: var(--blue-lt);
  text-decoration: none;
}
.blog-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform .25s ease;
}
.blog-card:hover .blog-thumb img {
  transform: scale(1.04);
}
.blog-thumb-fallback {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 58px;
  font-weight: 800;
}
.blog-thumb-fallback span {
  position: relative;
  z-index: 1;
}
.blog-body {
  padding-bottom: 18px;
}
.blog-title {
  font-size: 18px;
}
.blog-excerpt {
  margin-bottom: 0;
}
.tutorials-all-posts {
  display: flex;
  justify-content: center;
  margin-top: 42px;
}
.tutorials-hero {
  min-height: 520px;
  display: grid;
  grid-template-columns: 1.1fr 0.9fr;
  align-items: center;
  gap: 48px;
  padding: 100px 64px 64px;
  background: linear-gradient(180deg, rgba(247,249,252,1) 0%, rgba(235,242,255,1) 100%);
}
.tutorials-hero .hero-content { max-width: 560px; }
.tutorials-hero .hero-pill { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 999px; background: rgba(17,85,204,.08); color: var(--blue); font-size: 13px; font-weight: 700; letter-spacing: .35px; margin-bottom: 22px; }
.tutorials-hero .hero-sub { font-size: 18px; line-height: 1.85; color: var(--muted); max-width: 520px; margin-top: 12px; }
.tutorials-hero-visual { display: flex; justify-content: center; }
.tutorials-image-card {
  width: 100%; max-width: 520px;
  border-radius: 32px;
  padding: 32px;
  background: white;
  box-shadow: 0 30px 80px rgba(22, 47, 105, 0.12);
  display: grid;
  gap: 24px;
  border: 1px solid rgba(17,85,204,.11);
}
.tutorials-image-header { display: flex; gap: 10px; }
.tutorials-image-header .dot { width: 12px; height: 12px; border-radius: 50%; background: rgba(17,85,204,.3); }
.tutorials-image-body { display: grid; gap: 16px; }
.tutorials-image-title { width: 65%; height: 18px; border-radius: 999px; background: linear-gradient(90deg, #115bcc, #2a8cff); }
.tutorials-image-line { height: 14px; border-radius: 999px; background: rgba(17,85,204,.14); }
.tutorials-image-line.short { width: 40%; }
.tutorials-image-line.medium { width: 70%; }
.tutorials-image-line.long { width: 100%; }
.tutorials-image-footer { display: flex; gap: 16px; align-items: center; }
.tutorials-image-chip { width: 22%; height: 34px; border-radius: 999px; background: rgba(17,85,204,.12); }
.tutorials-image-chip.wide { width: 40%; }
@media (max-width: 960px) {
  .tutorial-banner {
    min-height: 310px;
    padding-top: 124px;
    padding-bottom: 56px;
  }
  .tutorials-hero { grid-template-columns: 1fr; padding: 80px 32px 48px; }
  .tutorials-hero-visual { margin-top: 36px; }
}
@media (max-width: 640px) {
  .tutorial-banner {
    min-height: 260px;
    padding: 112px 24px 44px;
  }
  .tutorials-hero { padding: 64px 24px 32px; }
  .tutorials-hero .hero-sub { font-size: 16px; }
}
</style>
@endpush
@endsection
