{{-- ═══════════════════════════════
     Partial: Free Study Materials (dynamic)
     Variables: $materials (Collection), $settings (array)
     ═══════════════════════════════ --}}
<section class="materials" id="materials" aria-labelledby="materials-heading">
  <div class="section-head center reveal">
    <span class="sec-label">📥 Free Resources</span>
    <h2 class="sec-title" id="materials-heading">Free Study Materials</h2>
    <p class="sec-desc">Download free notes, chapter summaries and practice papers — no sign-up required.</p>
  </div>

  <div class="materials-grid">
    @forelse($materials as $mat)
    <div class="mat-card reveal">
      <div class="mat-icon-wrap {{ $mat->icon_bg_class }}">{{ $mat->icon }}</div>
      <div class="mat-title">{{ $mat->title }}</div>
      <div class="mat-desc">{{ $mat->description }}</div>
      <div class="mat-meta">
        @foreach($mat->tags ?? [] as $tag)
          <span class="mat-tag">{{ $tag }}</span>
        @endforeach
      </div>
      @if($mat->external_url)
        <a href="{{ $mat->external_url }}" target="_blank" rel="noopener" class="download-btn">
          &#8595; Download
        </a>
      @else
        <button class="download-btn"
                onclick="simulateDownload(this,'{{ Str::slug($mat->title) }}.pdf')">
          &#8595; Download
        </button>
      @endif
    </div>
    @empty
    <div class="mat-card reveal" style="text-align:center;">
      <div style="font-size:40px;margin-bottom:14px;">📂</div>
      <div>No materials available yet.</div>
    </div>
    @endforelse

    {{-- Coming soon card --}}
    <div class="mat-card reveal"
         style="border:2px dashed var(--border);background:transparent;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;min-height:280px;">
      <div style="font-size:40px;margin-bottom:14px;opacity:.35;">📂</div>
      <div style="font-size:15px;font-weight:700;color:var(--muted);margin-bottom:8px;">More Materials Soon</div>
      <div style="font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:18px;">
        Subscribe to our YouTube channel to get notified when new free resources are uploaded.
      </div>
      <a href="{{ $settings['youtube_url'] ?? '#' }}" target="_blank" rel="noopener"
         class="btn btn-outline" style="font-size:13px;padding:10px 20px;">
        &#9654; Subscribe on YouTube
      </a>
    </div>
  </div>
</section>
