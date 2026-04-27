<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Daily Free Quiz – {{ $settings['site_name'] ?? 'Global World Academy' }} | MPTET Practice MCQs</title>
<meta name="description" content="Take Global World Academy's free daily MPTET quiz. Practice Science, Child Development, General Knowledge and MP GK MCQs for MPTET Varg 2 &amp; Varg 3 preparation."/>
<meta name="keywords" content="MPTET quiz, free MCQ quiz, MPTET practice, Varg 2 quiz, Varg 3 quiz, Science MCQ, Child Development MCQ, MP GK quiz"/>
<meta name="robots" content="index, follow"/>
<link rel="canonical" href="{{ route('quiz') }}"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="Daily Free Quiz – {{ $settings['site_name'] ?? 'Global World Academy' }} | MPTET Practice MCQs"/>
<meta property="og:url" content="{{ route('quiz') }}"/>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>

<!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/site.css') }}"/>
<link rel="stylesheet" href="{{ asset('css/quiz-page.css') }}"/>
</head>
<body>

<!-- ══ TOP BANNER ══ -->
<div class="top-banner">
  <div class="banner-inner">
    <div class="brand-row">
      <div class="brand-left">
        <div class="logo-mark-banner" aria-hidden="true">GW</div>
        <div>
          <div class="brand-name">Global <span>World</span> Academy</div>
          <div class="brand-tagline">MPTET Expert Coaching — Varg 2 &amp; Varg 3</div>
        </div>
      </div>
      <div class="brand-links">
        <a class="hdr-link link-home" href="{{ url('/') }}">&larr; Home</a>
        <a class="hdr-link link-yt" href="{{ $settings['youtube_url'] ?? '#' }}" target="_blank" rel="noopener">&#9654; YouTube</a>
        <a class="hdr-link link-course" href="{{ $settings['classplus_url'] ?? '#' }}" target="_blank" rel="noopener">📚 Courses</a>
      </div>
    </div>
    <div class="quiz-meta-strip">
      <div class="qm-title">🧠 <span id="quizTopicLabel">Daily Science Quiz</span></div>
      <div class="quiz-date-pill" id="quizDateLabel">Loading...</div>
    </div>
  </div>

  <!-- Topic tabs (dynamically rendered from DB topics) -->
  <div class="topic-tabs" role="tablist" aria-label="Quiz topics">
    @php
      $topicIcons = ['science'=>'🔬','child_dev'=>'👶','gk'=>'🌍','mp'=>'🗺️'];
      $topicNames = ['science'=>'Science','child_dev'=>'Child Dev','gk'=>'General Knowledge','mp'=>'MP GK'];
      $first = true;
    @endphp
    @foreach($quizData->keys() as $topic)
    <button class="topic-tab {{ $first ? 'active' : '' }}"
            onclick="loadQuiz('{{ $topic }}',this)"
            role="tab" aria-selected="{{ $first ? 'true' : 'false' }}">
      {{ $topicIcons[$topic] ?? '📝' }} {{ $topicNames[$topic] ?? ucfirst($topic) }}
    </button>
    @php $first = false; @endphp
    @endforeach
  </div>

  @include('partials.ticker')
</div>

<!-- ══ MAIN ══ -->
<div class="quiz-page-main">

  <div class="quiz-stats-row">
    <div class="qs-card"><span class="qs-num">10</span><span class="qs-lbl">Questions</span></div>
    <div class="qs-card"><span class="qs-num">{{ $quizData->count() }}</span><span class="qs-lbl">Topics</span></div>
    <div class="qs-card"><span class="qs-num">Free</span><span class="qs-lbl">No Login</span></div>
  </div>

  <!-- Quiz Widget -->
  <div class="quiz-widget" role="main" aria-label="Quiz widget">
    <div class="quiz-widget-header">
      <div class="quiz-title-row">
        <span class="quiz-icon" id="quizIcon" aria-hidden="true">🔬</span>
        <span class="quiz-name" id="quizName">Science Quiz</span>
      </div>
      <span class="quiz-counter" id="quizCounter" aria-live="polite">1 / 10</span>
    </div>
    <div class="quiz-progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
      <div class="quiz-progress-fill" id="quizProgress" style="width:10%;"></div>
    </div>

    <div class="quiz-body" id="quizMain">
      <div class="quiz-question" id="quizQ" aria-live="polite">Loading question...</div>
      <div class="quiz-options" id="quizOpts"></div>
      <div class="quiz-explain" id="quizExplain" aria-live="polite"></div>
      <div class="quiz-actions">
        <span id="quizFeedback" aria-live="assertive"></span>
        <button class="btn btn-blue" id="nextBtn" style="display:none;" onclick="nextQuestion()">Next &rarr;</button>
      </div>
    </div>

    <div class="quiz-result" id="quizResult" aria-live="polite">
      <div class="result-trophy" id="resultTrophy" aria-hidden="true">🏆</div>
      <div class="score-big" id="scoreNum">0/10</div>
      <div class="score-label">Your Score</div>
      <div class="result-msg" id="resultMsg">Well done!</div>
      <div class="result-actions">
        <button class="btn btn-outline" onclick="restartQuiz()">🔄 Try Again</button>
        <a href="{{ $settings['classplus_url'] ?? '#' }}" target="_blank" rel="noopener" class="btn btn-green">
          📚 Enroll for Full Course &rarr;
        </a>
      </div>
    </div>
  </div>

  <!-- Share Block -->
  <div class="share-block" id="shareBlock" style="display:none;" aria-label="Share quiz results">
    <p>📢 Share this quiz with your friends preparing for MPTET!</p>
    <div class="share-btns">
      <a class="share-btn sb-wa" id="shareWa" href="#" target="_blank" rel="noopener">📱 Share on WhatsApp</a>
      <a class="share-btn sb-tg" id="shareTg" href="#" target="_blank" rel="noopener">✈ Share on Telegram</a>
    </div>
  </div>

  <!-- Info Cards -->
  <div class="info-cards">
    <div class="info-card"><div class="ic-icon">⏱️</div><div><div class="ic-title">No Time Limit</div><div class="ic-desc">Attempt at your own pace — take your time to think through each answer carefully.</div></div></div>
    <div class="info-card"><div class="ic-icon">💡</div><div><div class="ic-title">Explanations Included</div><div class="ic-desc">Every question comes with a detailed explanation to reinforce your learning.</div></div></div>
    <div class="info-card"><div class="ic-icon">🔄</div><div><div class="ic-title">Multiple Topics</div><div class="ic-desc">Switch between topics using the tabs above.</div></div></div>
    <div class="info-card"><div class="ic-icon">📊</div><div><div class="ic-title">Instant Score</div><div class="ic-desc">Get your score immediately after completing all questions.</div></div></div>
  </div>

  <div class="page-footer">
    <div class="footer-brand-name">{{ $settings['site_name'] ?? 'Global World Academy' }}</div>
    <div class="footer-links">
      <a href="{{ url('/') }}">&larr; Back to Home</a>
      <a href="{{ $settings['youtube_url'] ?? '#' }}" target="_blank" rel="noopener">&#9654; YouTube Channel</a>
      <a href="{{ $settings['classplus_url'] ?? '#' }}" target="_blank" rel="noopener">📦 All Courses</a>
      <a href="tel:{{ $settings['phone'] ?? '+918770803840' }}">📞 {{ $settings['phone'] ?? '+91-8770803840' }}</a>
    </div>
    <div class="footer-note">
      MPTET Varg 2 &amp; Varg 3 Expert Coaching &middot; Free Daily Quizzes &middot;
      &copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Global World Academy' }}
    </div>
  </div>

</div>

<script>
  window.quizData = {!! json_encode($quizData) !!};
</script>
<script src="{{ asset('js/quiz-page.js') }}"></script>
</body>
</html>
