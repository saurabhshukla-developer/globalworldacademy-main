{{-- ═══════════════════════════════
     Partial: Courses Section (dynamic)
     Variables: $courses (Collection), $settings (array)
     ═══════════════════════════════ --}}
<section class="courses" id="courses" aria-labelledby="courses-heading">
  <div class="courses-flex reveal">
    <div>
      <span class="sec-label">📦 Our Courses</span>
      <h2 class="sec-title" id="courses-heading">Premium Course Offerings</h2>
      <p class="sec-desc">Designed for MPTET Varg 2 &amp; Varg 3 — based on the latest 2026 syllabus.</p>
    </div>
    <a href="{{ $settings['classplus_url'] ?? 'https://classplusapp.com/w/global-world-academy-xygeb' }}"
       target="_blank" rel="noopener" class="btn btn-outline">
      View All on App &rarr;
    </a>
  </div>

  <div class="courses-grid">
    @forelse($courses as $course)
    <article class="course-card reveal">
      <div class="course-thumb {{ $course->thumb_class }}">
        @if($course->badge)
          <div class="badge-new {{ $course->badge_style }}">{{ $course->badge }}</div>
        @endif
        {{ $course->thumb_icon }}
      </div>
      <div class="course-body">
        <span class="course-exam-tag">{{ $course->exam_tag }}</span>
        <div class="course-name">{{ $course->name }}</div>
        <div class="course-desc">{{ $course->description }}</div>
        <ul class="course-includes">
          @foreach($course->features ?? [] as $feature)
            <li>{{ $feature }}</li>
          @endforeach
        </ul>
      </div>
      <div class="course-footer">
        <div>
          <span class="price-now">&#8377;{{ number_format($course->price) }}</span>
          @if($course->old_price)
            <span class="price-old">&#8377;{{ number_format($course->old_price) }}</span>
            @if($course->discount_percent)
              <span class="price-off">{{ $course->discount_percent }}% OFF</span>
            @endif
          @endif
        </div>
        <a href="{{ $course->buy_url }}" target="_blank" rel="noopener" class="buy-btn">Buy Now</a>
      </div>
    </article>
    @empty
    <div class="course-card placeholder reveal">
      <div class="placeholder-icon">📦</div>
      <div class="placeholder-text">Courses coming soon. Check back later!</div>
    </div>
    @endforelse

    {{-- Always show these placeholder cards at the end --}}
    <div class="course-card placeholder reveal">
      <div class="placeholder-icon">🆕</div>
      <div class="course-name" style="color:var(--muted);margin-bottom:8px;">New Course Coming Soon</div>
      <div class="placeholder-text">Stay tuned or contact us to know more.</div>
      <br/>
      <a href="{{ $settings['youtube_url'] ?? '#' }}" target="_blank" rel="noopener"
         class="btn btn-outline" style="margin-top:auto;">Watch Free on YouTube</a>
    </div>

    <div class="course-card placeholder reveal">
      <div class="placeholder-icon">📌</div>
      <div class="course-name" style="color:var(--muted);margin-bottom:8px;">More Courses on App</div>
      <div class="placeholder-text">Visit our Classplus app page to see all available courses.</div>
      <br/>
      <a href="{{ $settings['classplus_url'] ?? '#' }}" target="_blank" rel="noopener"
         class="btn btn-blue" style="margin-top:auto;">View All Courses &rarr;</a>
    </div>
  </div>
</section>
