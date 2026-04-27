{{-- ═══════════════════════════════
     Partial: Navigation Bar (with language switcher)
     ═══════════════════════════════ --}}
<nav id="navbar">
  <a href="{{ url('/') }}" class="logo" aria-label="{{ __('site.nav_courses') }}">
    <div class="logo-mark" aria-hidden="true">GW</div>
    <div class="logo-name">Global <span>World</span> Academy</div>
  </a>

  <ul>
    <li><a href="{{ url('/') }}#courses">{{ __('site.nav_courses') }}</a></li>
    <li><a href="{{ url('/') }}#quiz">{{ __('site.nav_quiz') }}</a></li>
    <li><a href="{{ url('/') }}#materials">{{ __('site.nav_materials') }}</a></li>
    <li><a href="{{ url('/') }}#youtube">{{ __('site.nav_youtube') }}</a></li>
    <li><a href="{{ url('/') }}#faq">{{ __('site.nav_faq') }}</a></li>

    {{-- Language Switcher --}}
    <li>
      @if(app()->getLocale() === 'hi')
        <a href="{{ url()->current() }}?lang=en" class="lang-btn" title="{{ __('site.lang_switch_to_en') }}">EN</a>
      @else
        <a href="{{ url()->current() }}?lang=hi" class="lang-btn" title="{{ __('site.lang_switch_to_hi') }}">हिंदी</a>
      @endif
    </li>

    <li>
      <a href="{{ $settings['classplus_url'] ?? 'https://classplusapp.com/w/global-world-academy-xygeb' }}"
         target="_blank" rel="noopener" class="nav-cta">
        {{ __('site.nav_enroll') }} &rarr;
      </a>
    </li>
  </ul>

  <button class="hamburger" id="ham" onclick="toggleMenu()"
          aria-label="Toggle navigation" aria-expanded="false">
    <span></span><span></span><span></span>
  </button>
</nav>

<div class="mobile-menu" id="mobileMenu" role="navigation" aria-label="Mobile navigation">
  <a href="{{ url('/') }}#courses"   onclick="closeMenu()">{{ __('site.nav_courses') }}</a>
  <a href="{{ url('/') }}#quiz"      onclick="closeMenu()">{{ __('site.nav_quiz') }}</a>
  <a href="{{ url('/') }}#materials" onclick="closeMenu()">{{ __('site.nav_materials') }}</a>
  <a href="{{ url('/') }}#youtube"   onclick="closeMenu()">{{ __('site.nav_youtube') }}</a>
  <a href="{{ url('/') }}#faq"       onclick="closeMenu()">{{ __('site.nav_faq') }}</a>
  <a href="{{ route('quiz') }}"      onclick="closeMenu()">{{ __('site.nav_quiz_page') }}</a>
  <div style="display:flex;gap:8px;padding:8px 0;">
    <a href="{{ url()->current() }}?lang=en" class="lang-btn {{ app()->getLocale()=='en'?'active':'' }}">EN</a>
    <a href="{{ url()->current() }}?lang=hi" class="lang-btn {{ app()->getLocale()=='hi'?'active':'' }}">हिंदी</a>
  </div>
  <a href="{{ $settings['classplus_url'] ?? '#' }}" target="_blank" rel="noopener"
     class="btn btn-blue" style="border-radius:50px;justify-content:center;" onclick="closeMenu()">
    {{ __('site.nav_enroll') }} &rarr;
  </a>
</div>

@push('styles')
<style>
.lang-btn {
  display:inline-flex; align-items:center; justify-content:center;
  padding:6px 12px; border-radius:50px;
  font-size:12px; font-weight:700;
  background:var(--blue-lt); color:var(--blue);
  border:1px solid rgba(17,85,204,.2);
  transition:all .15s; cursor:pointer;
  font-family:'Sora',sans-serif; text-decoration:none;
}
.lang-btn:hover, .lang-btn.active { background:var(--blue); color:#fff; }
</style>
@endpush
