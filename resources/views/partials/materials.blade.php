{{-- ═══════════════════════════════
     Partial: Free Study Materials (dynamic)
     Variables: $materials (Collection), $settings (array)
     ═══════════════════════════════ --}}
<section class="materials" id="materials" aria-labelledby="materials-heading">
  <div class="section-head center reveal">
    <span class="sec-label">{{ __('site.materials_label') }}</span>
    <h2 class="sec-title" id="materials-heading">{{ __('site.materials_title') }}</h2>
    <p class="sec-desc">{{ __('site.materials_desc') }}</p>
    <p style="margin-top:16px;">
      <a href="{{ route('study-materials') }}" class="btn btn-outline">{{ __('site.materials_view_all') }}</a>
    </p>
  </div>

  <div class="materials-grid">
    @forelse($materials as $mat)
      @include('partials.material-card', ['mat' => $mat])
    @empty
    <div class="mat-card reveal" style="text-align:center;">
      <div style="font-size:40px;margin-bottom:14px;">📂</div>
      <div>{{ __('site.materials_empty') }}</div>
    </div>
    @endforelse

    {{-- Coming soon card --}}
    <div class="mat-card reveal"
         style="border:2px dashed var(--border);background:transparent;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;min-height:280px;">
      <div style="font-size:40px;margin-bottom:14px;opacity:.35;">📂</div>
      <div style="font-size:15px;font-weight:700;color:var(--muted);margin-bottom:8px;">{{ __('site.materials_more') }}</div>
      <div style="font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:18px;">
        {{ __('site.materials_more_sub') }}
      </div>
      <a href="{{ $settings['youtube_url'] ?? '#' }}" target="_blank" rel="noopener noreferrer"
         class="btn btn-outline" style="font-size:13px;padding:10px 20px;">
        {{ __('site.materials_yt_btn') }}
      </a>
    </div>
  </div>
</section>
