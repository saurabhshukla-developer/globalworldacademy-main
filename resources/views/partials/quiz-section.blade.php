{{-- ═══════════════════════════════
     Partial: Quiz Section (Landing Page)
     ═══════════════════════════════ --}}
<section class="quiz-section" id="quiz" aria-labelledby="quiz-heading">
  <div class="quiz-layout">

    {{-- Left: Info --}}
    <div class="quiz-info reveal">
      <span class="sec-label">🧠 Free Practice</span>
      <h2 class="sec-title" id="quiz-heading">Test Your Knowledge</h2>
      <p class="sec-desc">
        Attempt our free MCQ quizzes — MPTET Science, General Knowledge,
        Child Development and more.
      </p>
      <ul class="quiz-features">
        <li><div class="qf-icon">⏱️</div> 10 questions per quiz — attempt anytime</li>
        <li><div class="qf-icon">📊</div> Instant score with correct answers shown</li>
        <li><div class="qf-icon">💡</div> Explanation provided for every question</li>
        <li><div class="qf-icon">🔄</div> New quiz sets added regularly</li>
      </ul>
      <div style="margin-top:28px;">
        <p style="font-size:13px;color:rgba(255,255,255,.5);margin-bottom:12px;font-weight:600;text-transform:uppercase;letter-spacing:1px;">
          Choose a Topic:
        </p>
        <div class="quiz-topics">
          <button class="quiz-topic-btn active" onclick="loadQuiz('science', this)">🔬 Science</button>
          <button class="quiz-topic-btn" onclick="loadQuiz('child_dev', this)">👶 Child Development</button>
          <button class="quiz-topic-btn" onclick="loadQuiz('gk', this)">🌍 General Knowledge</button>
          <button class="quiz-topic-btn" onclick="loadQuiz('mp', this)">🗺️ MP GK</button>
        </div>
      </div>
      <a href="{{ route('quiz') }}" class="quiz-full-link">→ Open Full Daily Quiz Page</a>
    </div>

    {{-- Right: Widget --}}
    <div class="reveal">
      <div class="quiz-widget" id="quizWidget">
        <div class="quiz-header">
          <div class="quiz-title-row">
            <span class="quiz-icon" id="quizIcon">🔬</span>
            <span class="quiz-name" id="quizName">Science Quiz</span>
          </div>
          <span class="quiz-counter" id="quizCounter" aria-live="polite">1 / 10</span>
        </div>
        <div class="quiz-progress-bar">
          <div class="quiz-progress-fill" id="quizProgress" style="width:10%;"></div>
        </div>

        {{-- Question screen --}}
        <div id="quizMain">
          <div class="quiz-question" id="quizQ" aria-live="polite">Loading question...</div>
          <div class="quiz-options" id="quizOpts"></div>
          <div class="quiz-explain" id="quizExplain" aria-live="polite"></div>
          <div class="quiz-actions">
            <span id="quizFeedback" style="font-size:13px;font-weight:600;" aria-live="assertive"></span>
            <button class="btn btn-blue" id="nextBtn" style="display:none;" onclick="nextQuestion()">
              Next &rarr;
            </button>
          </div>
        </div>

        {{-- Result screen --}}
        <div class="quiz-result" id="quizResult" aria-live="polite">
          <div class="score" id="scoreNum">0/10</div>
          <div class="score-label">Your Score</div>
          <div class="result-msg" id="resultMsg">Well done!</div>
          <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <button class="btn btn-outline" onclick="restartQuiz()">🔄 Try Again</button>
            <a href="https://classplusapp.com/w/global-world-academy-xygeb"
               target="_blank" rel="noopener" class="btn btn-green">
              📚 Enroll for Full Course &rarr;
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
