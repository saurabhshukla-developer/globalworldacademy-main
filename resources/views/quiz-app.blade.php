<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Daily Free Quiz - {{ $settings['site_name'] ?? 'Global World Academy' }} | MPTET Practice MCQs</title>
<meta name="description" content="Take Global World Academy's free MPTET quiz by subject and topic. Practice Science, Child Development, General Knowledge and MP GK MCQs for MPTET Varg 2 &amp; Varg 3 preparation."/>
<meta name="keywords" content="MPTET quiz, free MCQ quiz, MPTET practice, Varg 2 quiz, Varg 3 quiz, Science MCQ, Child Development MCQ, MP GK quiz"/>
<meta name="robots" content="index, follow"/>
<link rel="canonical" href="{{ route('quiz') }}"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="Daily Free Quiz - {{ $settings['site_name'] ?? 'Global World Academy' }} | MPTET Practice MCQs"/>
<meta property="og:url" content="{{ route('quiz') }}"/>

<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&family=Noto+Sans+Devanagari:wght@400;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>

<link rel="stylesheet" href="{{ asset('css/site.css') }}"/>
<link rel="stylesheet" href="{{ asset('css/quiz-browser.css') }}?v={{ filemtime(public_path('css/quiz-browser.css')) }}"/>
</head>
<body class="quiz-app-page">

<header class="quiz-top-header">
  <a class="quiz-header-brand" href="{{ route('home') }}" aria-label="Global World Academy home">
    <div class="logo-mark" aria-hidden="true">GW</div>
    <div class="quiz-brand-name">Global <span>World</span> Academy</div>
  </a>
  <div class="quiz-header-links">
    <a class="quiz-header-btn quiz-btn-home" href="{{ route('home') }}">&larr; Home</a>
    <a class="quiz-header-btn quiz-btn-enroll" href="{{ $settings['classplus_url'] ?? 'https://classplusapp.com/w/global-world-academy-xygeb' }}" target="_blank" rel="noopener">📚 Enroll</a>
  </div>
</header>

<div class="quiz-layout">
  <div class="quiz-topics-backdrop" id="quizTopicsBackdrop" aria-hidden="true"></div>
  <aside class="quiz-sidebar" id="quizSidebar" aria-label="{{ app()->getLocale() === 'hi' ? 'क्विज़ विषय व टॉपिक' : 'Quiz subjects and topics' }}">
    <div class="quiz-sidebar-header">
      <div class="quiz-sidebar-heading">
        <div class="quiz-sidebar-title">📋 Quiz Topics</div>
        <div class="quiz-sidebar-sub">{{ app()->getLocale() === 'hi' ? 'विषय और टॉपिक चुनें' : 'Choose a subject and topic' }}</div>
      </div>
      <button type="button" class="quiz-drawer-close-btn" id="quizDrawerCloseBtn" aria-label="{{ app()->getLocale() === 'hi' ? 'मेनू बंद करें' : 'Close topics menu' }}">
        <span aria-hidden="true">✕</span>
      </button>
    </div>
    <div class="quiz-sidebar-search">
      <input type="search" id="quizSearch" placeholder="{{ app()->getLocale() === 'hi' ? 'टॉपिक खोजें...' : 'Search topics...' }}" autocomplete="off"/>
    </div>
    <nav class="quiz-sidebar-nav" id="quizSidebarNav">
      @foreach($quizSubjects as $subject)
        <div class="subject-block">
          <button class="subject-btn" type="button" data-subject-id="{{ $subject['id'] }}">
            <span class="subject-left">
              <span class="subject-icon">{{ $subject['icon'] ?? '📘' }}</span>
              <span class="subject-copy">
                <span>{{ app()->getLocale() === 'hi' && !empty($subject['name_hi']) ? $subject['name_hi'] : $subject['name'] }}</span>
                <small>{{ $subject['name_hi'] ?? $subject['name'] }}</small>
              </span>
            </span>
            <span class="subject-meta"><span class="chevron">›</span></span>
          </button>
          <div class="topic-list">
            @foreach($subject['topics'] as $topic)
              <button class="topic-btn {{ empty($topic['questions']) ? 'empty-topic' : '' }}" type="button" data-subject-id="{{ $subject['id'] }}" data-topic-id="{{ $topic['id'] }}">
                <span class="topic-icon">{{ $topic['icon'] ?? '📝' }}</span>
                <span class="topic-copy">
                  <span>{{ app()->getLocale() === 'hi' && !empty($topic['name_hi']) ? $topic['name_hi'] : $topic['name'] }}</span>
                  <small>{{ $topic['name_hi'] ?? $topic['name'] }}</small>
                </span>
                <span class="topic-qcount">{{ count($topic['questions'] ?? []) }}Q</span>
              </button>
            @endforeach
          </div>
        </div>
      @endforeach
    </nav>
  </aside>

  <main class="quiz-main">
    <button class="topics-toggle-btn" type="button" id="showTopicsBtn" aria-expanded="false" aria-controls="quizSidebar">
      {{ app()->getLocale() === 'hi' ? '📋 विषय व टॉपिक' : '📋 Topics' }}
    </button>

    <section class="quiz-empty-state" id="emptyState" aria-live="polite">
      <div class="empty-icon">🧠</div>
      <h1>{{ app()->getLocale() === 'hi' ? 'Quiz शुरू करें' : 'Start Your Quiz' }}</h1>
      <p>{{ app()->getLocale() === 'hi' ? 'विषय और टॉपिक चुनें। प्रश्नोत्तरी तुरंत शुरू हो जाएगी।' : 'Choose a subject and topic. Your quiz will open instantly.' }}</p>
    </section>

    <section class="quiz-area" id="quizArea" aria-live="polite">
      <div class="quiz-topic-header">
        <div class="quiz-breadcrumb">Quiz &rsaquo; <span id="breadSubject"></span> &rsaquo; <span id="breadTopic"></span></div>
        <h1 class="quiz-topic-title"><span id="topicIcon" aria-hidden="true">📝</span><span id="topicName"></span></h1>
        <div class="quiz-stats-row">
          <div class="qstat"><span class="qstat-dot"></span><span id="statTotal">0</span> questions</div>
          <div class="qstat"><span class="qstat-dot qstat-green"></span><span id="statAnswered">0</span> answered</div>
          <div class="qstat"><span class="qstat-dot qstat-gold"></span>Page <span id="statPage">1</span> / <span id="statPages">1</span></div>
        </div>
      </div>

      <div class="score-panel" id="scorePanel">
        <div class="score-panel-inner">
          <div class="score-icon" id="scoreIcon" aria-hidden="true">💪</div>
          <div class="score-circle">
            <span class="score-num" id="scoreNum">0</span>
            <span class="score-den" id="scoreDen">/0</span>
          </div>
          <div class="score-label">{{ app()->getLocale() === 'hi' ? 'आपका स्कोर' : 'Your Score' }}</div>
          <div class="score-msg" id="scoreMsg"></div>
          <div class="score-actions">
            <button class="btn btn-outline" type="button" id="retryQuizBtn">Retake Quiz</button>
            <a class="btn btn-green" href="{{ $settings['classplus_url'] ?? 'https://classplusapp.com/w/global-world-academy-xygeb' }}" target="_blank" rel="noopener">{{ app()->getLocale() === 'hi' ? 'पूरा कोर्स एनरोल करें' : 'Enroll for Full Course' }} &rarr;</a>
          </div>
          <div class="score-share">
            <div class="score-share-text" id="scoreShareText"></div>
            <div class="score-share-actions">
              <button class="share-chip" type="button" id="copyScoreLink">Copy Link</button>
              <a class="share-chip share-wa" id="scoreShareWa" href="#" target="_blank" rel="noopener">WhatsApp</a>
              <a class="share-chip share-tg" id="scoreShareTg" href="#" target="_blank" rel="noopener">Telegram</a>
            </div>
            <div class="share-toast" id="scoreShareToast">Link copied.</div>
          </div>
        </div>
      </div>

      <div class="quiz-progress-wrap">
        <div class="quiz-progress-label">
          <span id="progressLabel">Q 1-15</span>
          <span id="progressPct">0% complete</span>
        </div>
        <div class="quiz-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
          <div class="quiz-progress-fill" id="progressFill"></div>
        </div>
      </div>

      <div class="questions-list" id="questionsList"></div>
      <div class="pagination" id="pagination" aria-label="Question pages"></div>

      <div class="quiz-cta-banner">
        <div>
          <div class="cta-title">{{ app()->getLocale() === 'hi' ? 'पूरी तैयारी के लिए पेड कोर्स देखें' : 'Prepare fully with our paid course' }}</div>
          <div class="cta-sub">{{ app()->getLocale() === 'hi' ? '5000+ MCQs, वीडियो क्लास, PDF नोट्स - एक जगह सब कुछ' : '5000+ MCQs, video classes, PDF notes - everything in one place' }}</div>
        </div>
        <a href="{{ $settings['classplus_url'] ?? 'https://classplusapp.com/w/global-world-academy-xygeb' }}" target="_blank" rel="noopener" class="btn btn-green">📚 Courses &rarr;</a>
      </div>
    </section>
  </main>
</div>

<script>
  window.quizSubjects = @json($quizSubjects);
  window.quizLabels = {
    lang: @json(app()->getLocale()),
    correct: @json(app()->getLocale() === 'hi' ? 'सही जवाब!' : 'Correct!'),
    wrong: @json(app()->getLocale() === 'hi' ? 'गलत! सही:' : 'Wrong! Correct:'),
    explanation: @json(app()->getLocale() === 'hi' ? 'व्याख्या:' : 'Explanation:'),
    noResults: @json(app()->getLocale() === 'hi' ? 'कोई परिणाम नहीं मिला।' : 'No results found.'),
    questions: @json(app()->getLocale() === 'hi' ? 'प्रश्न' : 'questions'),
    answered: @json(app()->getLocale() === 'hi' ? 'हल किए' : 'answered'),
    page: @json(app()->getLocale() === 'hi' ? 'पेज' : 'Page'),
    complete: @json(app()->getLocale() === 'hi' ? 'पूर्ण' : 'complete'),
    scorePerfect: @json(app()->getLocale() === 'hi' ? 'शानदार! पूरे नंबर! आप परीक्षा के लिए तैयार हैं।' : 'Perfect score! You are exam-ready.'),
    scoreGreat: @json(app()->getLocale() === 'hi' ? 'बहुत बढ़िया! ऐसे ही अभ्यास जारी रखें।' : 'Excellent! Keep practicing like this.'),
    scoreGood: @json(app()->getLocale() === 'hi' ? 'अच्छा प्रयास! व्याख्याएँ पढ़ें और दोबारा अभ्यास करें।' : 'Good effort! Review the explanations and try again.'),
    scoreLow: @json(app()->getLocale() === 'hi' ? 'और अभ्यास करें। सही मार्गदर्शन से स्कोर बेहतर होगा।' : 'Keep practicing. Guided preparation will improve your score.'),
    shareTitle: @json('Global World Academy Quiz'),
    tryQuiz: @json(app()->getLocale() === 'hi' ? 'यह क्विज आज़माएं:' : 'Try this quiz:')
  };
</script>
<script src="{{ asset('js/quiz-browser.js') }}?v={{ filemtime(public_path('js/quiz-browser.js')) }}"></script>
</body>
</html>
