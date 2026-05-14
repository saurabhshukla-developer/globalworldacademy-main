{{-- Single study material card; expects $mat (Material model) --}}
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
    <a href="{{ $mat->external_url }}" target="_blank" rel="noopener noreferrer" class="download-btn">
      {{ __('site.materials_download') }}
    </a>
  @else
    <button type="button" class="download-btn"
            onclick="simulateDownload(this,'{{ Str::slug($mat->title) }}.pdf')">
      {{ __('site.materials_download') }}
    </button>
  @endif
</div>
