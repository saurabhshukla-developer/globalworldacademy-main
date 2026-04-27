<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>@yield('title', 'Global World Academy – MPTET Expert Coaching')</title>

@yield('meta')

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&family=Noto+Sans+Devanagari:wght@400;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
@if(app()->getLocale() === 'hi')
<style>body,h1,h2,h3,p,.sec-desc,.hero-sub{font-family:'Noto Sans Devanagari','Sora',sans-serif;}</style>
@endif

<!-- Site CSS -->
<link rel="stylesheet" href="{{ asset('css/site.css') }}"/>

@stack('styles')
</head>
<body>

@include('partials.nav')

@yield('content')

@include('partials.footer')

<!-- JS -->
<script src="{{ asset('js/quiz-data.js') }}"></script>
<script src="{{ asset('js/site.js') }}"></script>

@stack('scripts')
</body>
</html>
