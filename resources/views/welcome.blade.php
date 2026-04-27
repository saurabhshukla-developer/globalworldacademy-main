@extends('layouts.site')

@section('title', "Global World Academy – India's Trusted MPTET Expert Coaching Online")

@section('meta')
<meta name="description" content="Global World Academy offers expert MPTET Varg 2 & Varg 3 online coaching — video classes, test series, free study materials & daily quizzes. Join 10,000+ aspirants across Madhya Pradesh."/>
<meta name="keywords" content="MPTET coaching, MPTET Varg 2, MPTET Varg 3, MP teacher exam, Madhya Pradesh teacher, online coaching, test series, science coaching, Global World Academy"/>
<meta name="robots" content="index, follow"/>
<link rel="canonical" href="{{ url('/') }}"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="Global World Academy – India's Trusted MPTET Expert Coaching"/>
<meta property="og:description" content="Expert video classes, comprehensive test series & free study material — designed specifically for MPTET Varg 2 & Varg 3 aspirants."/>
<meta property="og:url" content="{{ url('/') }}"/>
<meta property="og:site_name" content="Global World Academy"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="Global World Academy – MPTET Expert Coaching"/>
<meta name="twitter:description" content="Expert MPTET coaching for Varg 2 & Varg 3 — video classes, test series & free study material."/>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "EducationalOrganization",
  "name": "Global World Academy",
  "description": "India's trusted online coaching platform for MPTET Varg 2 & Varg 3 aspirants",
  "url": "{{ url('/') }}",
  "telephone": "+91-8770803840",
  "address": { "@@type": "PostalAddress", "addressCountry": "IN", "addressRegion": "Madhya Pradesh" },
  "sameAs": [
    "https://www.youtube.com/channel/UCAUjpk6WmdECWyGj90yl9Qg",
    "https://classplusapp.com/w/global-world-academy-xygeb"
  ]
}
</script>
@endsection

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
