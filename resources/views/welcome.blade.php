@extends('layouts.site')

@section('title', ($settings['site_name'] ?? 'Global World Academy') . " – " . ($settings['site_tagline'] ?? "India's Trusted MPTET Expert Coaching Online"))

@section('meta')
<meta name="description" content="Global World Academy offers expert MPTET Varg 2 &amp; Varg 3 online coaching — video classes, test series, free study materials &amp; daily quizzes. Join 10,000+ aspirants across Madhya Pradesh."/>
<meta name="keywords" content="MPTET coaching, MPTET Varg 2, MPTET Varg 3, MP teacher exam, Madhya Pradesh teacher, online coaching, test series, science coaching, Global World Academy"/>
<meta name="robots" content="index, follow"/>
<link rel="canonical" href="{{ url('/') }}"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="{{ $settings['site_name'] ?? 'Global World Academy' }} – MPTET Expert Coaching"/>
<meta property="og:description" content="Expert video classes, comprehensive test series &amp; free study material for MPTET Varg 2 &amp; Varg 3 aspirants."/>
<meta property="og:url" content="{{ url('/') }}"/>
<meta property="og:site_name" content="{{ $settings['site_name'] ?? 'Global World Academy' }}"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="{{ $settings['site_name'] ?? 'Global World Academy' }} – MPTET Expert Coaching"/>
<meta name="twitter:description" content="Expert MPTET coaching for Varg 2 &amp; Varg 3 — video classes, test series &amp; free study material."/>
@endsection

@push('scripts')
<script>
  {{-- Inject dynamic quiz data from DB --}}
  window.quizData = {!! json_encode($quizData) !!};
</script>
@endpush

@section('content')
  @include('partials.hero')
  @include('partials.ticker')
  @include('partials.stats')
  @include('partials.courses')
  @include('partials.quiz-section')
  @include('partials.materials')
  @include('partials.youtube')
  @include('partials.testimonials')
  @include('partials.faq')
  @include('partials.cta')
@endsection
