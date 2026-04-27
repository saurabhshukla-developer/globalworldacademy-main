/**
 * Global World Academy — Landing Page JS
 * Handles: quiz widget, nav, scroll reveal, FAQ, counter animation
 * Note: window.quizData is injected inline from the Blade template (DB-driven)
 */

/* ── QUIZ WIDGET (embedded in landing page) ─────────────── */
var currentQuiz = 'science';
var currentQ    = 0;
var score       = 0;
var answered    = false;

var lang = document.documentElement.lang || 'en';

function getLocalText(obj, key) {
  var hiKey = key + '_hi';
  return (lang === 'hi' && obj[hiKey]) ? obj[hiKey] : obj[key];
}

function loadQuiz(topic, btn) {
  currentQuiz = topic; currentQ = 0; score = 0; answered = false;
  document.querySelectorAll('.quiz-topic-btn').forEach(function(b) { b.classList.remove('active'); });
  if (btn) btn.classList.add('active');
  document.getElementById('quizResult').style.display = 'none';
  document.getElementById('quizMain').style.display   = 'block';
  document.getElementById('quizIcon').textContent = window.quizData[topic].icon;
  document.getElementById('quizName').textContent = getLocalText(window.quizData[topic], 'name');
  renderQuestion();
}

function renderQuestion() {
  var quiz  = window.quizData[currentQuiz];
  var q     = quiz.questions[currentQ];
  var total = quiz.questions.length;
  document.getElementById('quizCounter').textContent  = (currentQ + 1) + ' / ' + total;
  document.getElementById('quizProgress').style.width = (((currentQ + 1) / total) * 100) + '%';
  document.getElementById('quizQ').textContent = getLocalText(q, 'q');
  document.getElementById('quizExplain').style.display = 'none';
  document.getElementById('nextBtn').style.display     = 'none';
  document.getElementById('quizFeedback').textContent  = '';
  answered = false;
  var letters = ['A','B','C','D'];
  document.getElementById('quizOpts').innerHTML = q.opts.map(function(o, i) {
    return '<button class="quiz-opt" onclick="selectOpt(' + i + ')" id="opt' + i + '">' +
      '<span class="opt-letter">' + letters[i] + '</span>' + o + '</button>';
  }).join('');
}

function selectOpt(idx) {
  if (answered) return;
  answered = true;
  var q    = window.quizData[currentQuiz].questions[currentQ];
  var opts = document.querySelectorAll('.quiz-opt');
  opts.forEach(function(o) { o.disabled = true; });
  var fb        = document.getElementById('quizFeedback');
  var explainEl = document.getElementById('quizExplain');
  if (idx === q.ans) {
    opts[idx].classList.add('correct'); score++;
    fb.textContent = '✅ Correct!'; fb.style.color = 'var(--green)';
  } else {
    opts[idx].classList.add('wrong'); opts[q.ans].classList.add('correct');
    fb.textContent = '❌ Wrong!'; fb.style.color = 'var(--red)';
  }
  explainEl.textContent = '💡 ' + getLocalText(q, 'explain');
  explainEl.style.display  = 'block';
  document.getElementById('nextBtn').style.display = 'inline-flex';
}

function nextQuestion() {
  var total = window.quizData[currentQuiz].questions.length;
  currentQ++;
  if (currentQ >= total) showResult();
  else renderQuestion();
}

function showResult() {
  document.getElementById('quizMain').style.display  = 'none';
  document.getElementById('quizResult').style.display = 'block';
  var total = window.quizData[currentQuiz].questions.length;
  document.getElementById('scoreNum').textContent         = score + '/' + total;
  document.getElementById('quizProgress').style.width     = '100%';
  document.getElementById('quizCounter').textContent      = total + ' / ' + total;
  var pct = (score / total) * 100;
  var msg = '';
  if (pct === 100)     msg = '🏆 Perfect Score! You\'re exam-ready!';
  else if (pct >= 80)  msg = '🎉 Excellent! Great preparation!';
  else if (pct >= 60)  msg = '👍 Good effort! Keep practicing!';
  else if (pct >= 40)  msg = '📚 Keep studying — you\'re getting there!';
  else                 msg = '💪 Don\'t give up — enroll in our course for guided prep!';
  document.getElementById('resultMsg').textContent = msg;
}

function restartQuiz() { loadQuiz(currentQuiz, null); }

/* ── DOWNLOAD SIMULATE ───────────────────────────────────── */
function simulateDownload(btn, filename) {
  btn.textContent = '⏳ Preparing...'; btn.disabled = true;
  setTimeout(function() {
    btn.textContent = '✅ Downloaded!'; btn.classList.add('downloaded');
    setTimeout(function() { btn.textContent = '⬇ Download Again'; btn.disabled = false; }, 3000);
  }, 1200);
}

/* ── FAQ ACCORDION ───────────────────────────────────────── */
function toggleFaq(el) {
  var wasOpen = el.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(function(i) { i.classList.remove('open'); });
  if (!wasOpen) el.classList.add('open');
}

/* ── SCROLL REVEAL ───────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {
  var revEls = document.querySelectorAll('.reveal');
  var revObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(e, i) {
      if (e.isIntersecting) {
        e.target.style.transitionDelay = (i % 4) * 0.1 + 's';
        e.target.classList.add('visible');
      }
    });
  }, { threshold: 0.1 });
  revEls.forEach(function(el) { revObserver.observe(el); });

  /* ── NAV SHRINK ON SCROLL */
  var navEl = document.getElementById('navbar');
  window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
      navEl.style.padding    = '10px 64px';
      navEl.style.boxShadow  = '0 4px 24px rgba(0,0,0,.08)';
    } else {
      navEl.style.padding   = '16px 64px';
      navEl.style.boxShadow = 'none';
    }
  });

  /* ── COUNTER ANIMATION */
  function animateCounter(id, target) {
    var el = document.getElementById(id);
    if (!el) return;
    var start = 0, step = target / 60;
    var timer = setInterval(function() {
      start += step;
      if (start >= target) { el.textContent = target; clearInterval(timer); }
      else { el.textContent = Math.floor(start); }
    }, 20);
  }
  var statsBar = document.querySelector('.stats-bar');
  if (statsBar) {
    var statsObserver = new IntersectionObserver(function(entries) {
      if (entries[0].isIntersecting) {
        animateCounter('countStudents', 10);
        animateCounter('countMCQ', 5);
        animateCounter('countVideos', 500);
        animateCounter('countYears', 5);
        statsObserver.disconnect();
      }
    }, { threshold: 0.3 });
    statsObserver.observe(statsBar);
  }

  /* ── INIT QUIZ */
  loadQuiz('science', null);
});

/* ── MOBILE MENU ─────────────────────────────────────────── */
function toggleMenu() {
  var menu = document.getElementById('mobileMenu');
  var btn  = document.getElementById('ham');
  var open = menu.classList.toggle('open');
  btn.setAttribute('aria-expanded', open);
  // Animate hamburger to X
  var spans = btn.querySelectorAll('span');
  if (open) {
    spans[0].style.transform = 'rotate(45deg) translate(5px,5px)';
    spans[1].style.opacity   = '0';
    spans[2].style.transform = 'rotate(-45deg) translate(5px,-5px)';
  } else {
    spans[0].style.transform = '';
    spans[1].style.opacity   = '';
    spans[2].style.transform = '';
  }
}
function closeMenu() {
  var menu  = document.getElementById('mobileMenu');
  var btn   = document.getElementById('ham');
  var spans = btn.querySelectorAll('span');
  menu.classList.remove('open');
  btn.setAttribute('aria-expanded', 'false');
  spans[0].style.transform = '';
  spans[1].style.opacity   = '';
  spans[2].style.transform = '';
}

/* ── CLOSE MENU ON OUTSIDE CLICK ────────────────────────── */
document.addEventListener('click', function(e) {
  var menu = document.getElementById('mobileMenu');
  var ham  = document.getElementById('ham');
  if (menu && menu.classList.contains('open')) {
    if (!menu.contains(e.target) && !ham.contains(e.target)) closeMenu();
  }
});
