<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>@yield('title', 'Admin') — GWA Admin Panel</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}"/>
@stack('styles')
</head>
<body>
<div class="admin-wrapper">

  {{-- SIDEBAR --}}
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo">GW</div>
      <div class="sidebar-title">
        GWA Admin
        <span>Global World Academy</span>
      </div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-section">Main</div>
      <a href="{{ route('admin.dashboard') }}"
         class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="icon">📊</span> Dashboard
      </a>

      <div class="nav-section">Quiz</div>
      <a href="{{ route('admin.quiz-categories.index') }}"
         class="nav-link {{ request()->routeIs('admin.quiz-categories.*') ? 'active' : '' }}">
        <span class="icon">🗂️</span> Categories
      </a>
      <a href="{{ route('admin.quiz-topics.index') }}"
         class="nav-link {{ request()->routeIs('admin.quiz-topics.*') ? 'active' : '' }}">
        <span class="icon">🏷️</span> Topics
      </a>
      <a href="{{ route('admin.quiz.index') }}"
         class="nav-link {{ request()->routeIs('admin.quiz.index','admin.quiz.create','admin.quiz.edit') ? 'active' : '' }}">
        <span class="icon">🧠</span> Questions
      </a>

      <div class="nav-section">Content</div>
      <a href="{{ route('admin.courses.index') }}"
         class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
        <span class="icon">📚</span> Courses
      </a>
      <a href="{{ route('admin.materials.index') }}"
         class="nav-link {{ request()->routeIs('admin.materials.*') ? 'active' : '' }}">
        <span class="icon">📥</span> Study Materials
      </a>

      <div class="nav-section">WP Posts</div>
      <a href="{{ route('admin.post-categories.index') }}"
         class="nav-link {{ request()->routeIs('admin.post-categories.*') ? 'active' : '' }}">
        <span class="icon">📰</span> Post Categories
      </a>

      <div class="nav-section">Config</div>
      <a href="{{ route('admin.settings') }}"
         class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
        <span class="icon">⚙️</span> Site Settings
      </a>

      <div class="nav-section">Website</div>
      <a href="{{ route('home') }}" target="_blank" class="nav-link">
        <span class="icon">🌐</span> View Website
      </a>
      <a href="{{ route('quiz') }}" target="_blank" class="nav-link">
        <span class="icon">🧩</span> View Quiz Page
      </a>
    </nav>

    <div class="sidebar-footer">
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" style="background:none;border:none;cursor:pointer;width:100%;text-align:left;" class="nav-link">
          <span class="icon">🚪</span> Logout
        </button>
      </form>
    </div>
  </aside>

  {{-- MAIN --}}
  <div class="admin-main">
    {{-- TOPBAR --}}
    <header class="topbar">
      <div class="topbar-left">
        <button id="sidebarToggle" onclick="document.getElementById('sidebar').classList.toggle('open')"
                style="background:none;border:none;cursor:pointer;font-size:20px;display:none;" aria-label="Toggle sidebar">☰</button>
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
      </div>
      <div class="topbar-right">
        <div class="admin-badge">
          <div class="admin-avatar">{{ substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1) }}</div>
          <span>{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
        </div>
      </div>
    </header>

    {{-- CONTENT --}}
    <main class="page-content">
      @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-error">❌ {{ session('error') }}</div>
      @endif
      @yield('content')
    </main>
  </div>
</div>

<script>
  // Sidebar toggle for mobile
  var toggle = document.getElementById('sidebarToggle');
  if (window.innerWidth <= 768 && toggle) toggle.style.display = 'inline-flex';
  window.addEventListener('resize', function() {
    if (toggle) toggle.style.display = window.innerWidth <= 768 ? 'inline-flex' : 'none';
  });

  // Close sidebar on outside click (mobile)
  document.addEventListener('click', function(e) {
    var sidebar = document.getElementById('sidebar');
    if (window.innerWidth <= 768 && sidebar.classList.contains('open')) {
      if (!sidebar.contains(e.target) && e.target !== toggle) {
        sidebar.classList.remove('open');
      }
    }
  });
</script>
@stack('scripts')
</body>
</html>
