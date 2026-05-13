{{-- ═══════════════════════════════
     Partial: Hero Section (enhanced)
     Variables: $settings (array)
     ═══════════════════════════════ --}}
<section class="hero" aria-label="Hero section">
  <div class="hero-bg" aria-hidden="true"></div>
  <div class="hero-grid-lines" aria-hidden="true"></div>

  {{-- Floating particles --}}
  <div class="hero-particles" aria-hidden="true">
    <div class="particle p1"></div>
    <div class="particle p2"></div>
    <div class="particle p3"></div>
    <div class="particle p4"></div>
    <div class="particle p5"></div>
  </div>

  <div class="hero-content">
    <div class="hero-pill">
      <span class="live-dot" aria-hidden="true"></span> Live Classes on YouTube &nbsp;·&nbsp; Daily Updates
    </div>
    <h1>
      {!! nl2br(e($settings['hero_heading'] ?? "India's Trusted\nMPTET Coaching\nOnline Platform")) !!}
    </h1>
    <p class="hero-sub">
      {{ $settings['hero_sub'] ?? 'Expert video classes, comprehensive test series & free study material — designed specifically for MPTET Varg 2 & Varg 3 aspirants across Madhya Pradesh.' }}
    </p>
    <div class="hero-actions">
      <a href="{{ $settings['hero_cta_url'] ?? 'https://classplusapp.com/w/global-world-academy-xygeb' }}"
         target="_blank" rel="noopener" class="btn btn-blue">
        Browse Courses &rarr;
      </a>
      <a href="{{ route('quiz') }}" class="btn btn-outline">🧠 Take Free Quiz</a>
    </div>
    <div class="hero-trust">
      <div class="trust-avatars" aria-hidden="true">
        <div class="av av-a">R</div>
        <div class="av av-b">P</div>
        <div class="av av-c">A</div>
        <div class="av av-d">S</div>
      </div>
      <div class="trust-text">
        <strong>{{ $settings['stat_students'] ?? '10' }}K+ students</strong> already enrolled<br/>
        Trusted by MPTET aspirants across MP
      </div>
    </div>
  </div>

  <div class="hero-visual" aria-hidden="true">
    <div class="hero-phone-mockup">
      <div class="hpm-tag"><span>🔴</span> New Course Live</div>
      <div class="hpm-course">Varg 2 Science Mains<br/>Course &amp; Test Series</div>
      <div class="hpm-desc">Complete video classes with notes, chapter-wise MCQs &amp; full length tests — new syllabus.</div>
      <div class="hpm-stats">
        <div class="hpm-stat"><span class="n">5000+</span><span class="l">MCQ Practice</span></div>
        <div class="hpm-stat"><span class="n">100%</span><span class="l">New Syllabus</span></div>
        <div class="hpm-stat"><span class="n">PDF</span><span class="l">Notes Included</span></div>
      </div>
      <div class="hpm-divider"></div>
      <a href="{{ $settings['hero_cta_url'] ?? '#' }}" target="_blank" rel="noopener" class="hpm-btn">
        Buy Now — &#8377;776 &rarr;
      </a>
    </div>
    <div class="fc fc-1">
      <div class="fc-icon">📚</div>
      <div><div class="fc-title">PDF Notes</div><div class="fc-sub">All Chapters Covered</div></div>
    </div>
    <div class="fc fc-2">
      <div class="fc-icon">🏆</div>
      <div><div class="fc-title">Bilingual Classes</div><div class="fc-sub">Hindi + English</div></div>
    </div>
    <div class="fc fc-3">
      <div class="fc-icon">📞</div>
      <div>
        <div class="fc-title">{{ $settings['phone'] ?? '+91-8770803840' }}</div>
        <div class="fc-sub">Call to Enroll</div>
      </div>
    </div>
  </div>
</section>

@push('styles')
<style>
/* ── ENHANCED HERO PARTICLES ──────────────────────────────── */
.hero-particles { position:absolute; inset:0; z-index:0; pointer-events:none; overflow:hidden; }
.particle {
  position:absolute; border-radius:50%;
  background: linear-gradient(135deg, rgba(17,85,204,.15), rgba(232,160,32,.1));
  animation: particleFloat linear infinite;
}
.p1{width:80px;height:80px;top:15%;left:8%;animation-duration:18s;animation-delay:0s;}
.p2{width:50px;height:50px;top:65%;left:5%;animation-duration:14s;animation-delay:-4s;}
.p3{width:120px;height:120px;top:20%;right:5%;animation-duration:22s;animation-delay:-8s;opacity:.5;}
.p4{width:35px;height:35px;top:80%;right:12%;animation-duration:12s;animation-delay:-2s;}
.p5{width:65px;height:65px;top:45%;left:45%;animation-duration:16s;animation-delay:-6s;opacity:.4;}

/* hero h1 newlines */
.hero h1 br { display:block; }

/* bold blue in heading */
</style>
@endpush
