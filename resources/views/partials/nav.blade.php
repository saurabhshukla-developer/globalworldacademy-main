{{-- ═══════════════════════════════
     Partial: Navigation Bar
     ═══════════════════════════════ --}}
<nav id="navbar">
  <a href="{{ url('/') }}" class="logo" aria-label="Global World Academy Home">
    <div class="logo-mark" aria-hidden="true">GW</div>
    <div class="logo-name">Global <span>World</span> Academy</div>
  </a>

  <ul>
    <li><a href="{{ url('/') }}#courses">Courses</a></li>
    <li><a href="{{ url('/') }}#quiz">Free Quiz</a></li>
    <li><a href="{{ url('/') }}#materials">Study Material</a></li>
    <li><a href="{{ url('/') }}#youtube">YouTube</a></li>
    <li><a href="{{ url('/') }}#faq">FAQ</a></li>
    <li>
      <a href="https://classplusapp.com/w/global-world-academy-xygeb"
         target="_blank" rel="noopener" class="nav-cta">
        Enroll Now &rarr;
      </a>
    </li>
  </ul>

  <button class="hamburger" id="ham"
          onclick="toggleMenu()"
          aria-label="Toggle navigation menu"
          aria-expanded="false">
    <span></span><span></span><span></span>
  </button>
</nav>

<div class="mobile-menu" id="mobileMenu" role="navigation" aria-label="Mobile navigation">
  <a href="{{ url('/') }}#courses"   onclick="closeMenu()">Courses</a>
  <a href="{{ url('/') }}#quiz"      onclick="closeMenu()">Free Quiz</a>
  <a href="{{ url('/') }}#materials" onclick="closeMenu()">Study Material</a>
  <a href="{{ url('/') }}#youtube"   onclick="closeMenu()">YouTube</a>
  <a href="{{ url('/') }}#faq"       onclick="closeMenu()">FAQ</a>
  <a href="{{ route('quiz') }}"      onclick="closeMenu()">Daily Quiz Page</a>
  <a href="https://classplusapp.com/w/global-world-academy-xygeb"
     target="_blank" rel="noopener"
     class="btn btn-blue"
     style="border-radius:50px;justify-content:center;"
     onclick="closeMenu()">
    Enroll Now &rarr;
  </a>
</div>
