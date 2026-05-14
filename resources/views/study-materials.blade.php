@extends('layouts.site')

@section('title', __('site.study_materials_title').' – '.($settings['site_name'] ?? 'Global World Academy'))

@section('meta')
<meta name="description" content="{{ __('site.study_materials_meta_description') }}"/>
<meta name="robots" content="index, follow"/>
<link rel="canonical" href="{{ route('study-materials') }}"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="{{ __('site.study_materials_title') }} – {{ $settings['site_name'] ?? 'Global World Academy' }}"/>
<meta property="og:description" content="{{ __('site.study_materials_meta_description') }}"/>
<meta property="og:url" content="{{ route('study-materials') }}"/>
@endsection

@section('content')
@php
  $anyTopicMaterials = $subjects->contains(fn ($s) => $s->activeTopics->contains(fn ($t) => $t->materials->isNotEmpty()));
@endphp

<article class="materials study-materials-page" aria-labelledby="study-materials-heading">
  <div class="section-head center reveal">
    <span class="sec-label">{{ __('site.materials_label') }}</span>
    <h1 class="sec-title" id="study-materials-heading">{{ __('site.study_materials_title') }}</h1>
    <p class="sec-desc">{{ __('site.study_materials_intro') }}</p>
    <p style="margin-top:12px;">
      <a href="{{ route('home') }}#materials" class="btn btn-outline" style="font-size:13px;">← {{ __('site.study_materials_back_home') }}</a>
    </p>
  </div>

  @if($uncategorized->isNotEmpty())
    <section class="reveal" aria-labelledby="study-materials-general-heading">
      <h2 class="study-topic-heading" id="study-materials-general-heading">{{ __('site.study_materials_uncategorized') }}</h2>
      <div class="materials-grid">
        @foreach($uncategorized as $mat)
          @include('partials.material-card', ['mat' => $mat])
        @endforeach
      </div>
    </section>
  @endif

  @foreach($subjects as $subject)
    @php
      $topicsWithMaterials = $subject->activeTopics->filter(fn ($t) => $t->materials->isNotEmpty());
    @endphp
    @continue($topicsWithMaterials->isEmpty())

    <section id="subject-{{ $subject->slug }}" class="reveal study-subject-section" aria-labelledby="subject-heading-{{ $subject->slug }}">
      <h2 class="study-subject-heading" id="subject-heading-{{ $subject->slug }}">{{ $subject->local_name }}</h2>

      @foreach($topicsWithMaterials as $topic)
        <div id="topic-{{ $topic->slug }}" class="study-topic-section">
          <h3 class="study-topic-heading">{{ $topic->local_name }}</h3>
          <div class="materials-grid">
            @foreach($topic->materials as $mat)
              @include('partials.material-card', ['mat' => $mat])
            @endforeach
          </div>
        </div>
      @endforeach
    </section>
  @endforeach

  @if($uncategorized->isEmpty() && ! $anyTopicMaterials)
    <div class="mat-card reveal" style="text-align:center;max-width:480px;margin:32px auto;">
      <div style="font-size:40px;margin-bottom:14px;">📂</div>
      <div>{{ __('site.materials_empty') }}</div>
    </div>
  @endif
</article>
@endsection
