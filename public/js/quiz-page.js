/**
 * Global World Academy — Quiz Standalone Page JS
 */

var currentTopic = 'science';
var currentQ     = 0;
var score        = 0;
var answered     = false;
var letters      = ['A', 'B', 'C', 'D'];

function init() {
  var now = new Date();
  var options = { year: 'numeric', month: 'long', day: 'numeric' };
  document.getElementById('quizDateLabel').textContent = now.toLocaleDateString('en-IN', options);
  loadQuiz('science', document.querySelector('.topic-tab'));
}

function loadQuiz(topic, btn) {
  currentTopic = topic; currentQ = 0; score = 0; answered = false;
  document.querySelectorAll('.topic-tab').forEach(function(b) {
    b.classList.remove('active'); b.setAttribute('aria-selected', 'false');
  });
  if (btn) { btn.classList.add('active'); btn.setAttribute('aria-selected', 'true'); }
  var data = window.quizData[topic];
  document.getElementById('quizTopicLabel').textContent = data.name;
  document.getElementById('quizIcon').textContent       = data.icon;
  document.getElementById('quizName').textContent       = data.name;
  document.getElementById('quizResult').style.display   = 'none';
  document.getElementById('quizMain').style.display     = 'block';
  document.getElementById('shareBlock').style.display   = 'none';
  renderQuestion();
}

function renderQuestion() {
  var q     = window.quizData[currentTopic].questions[currentQ];
  var total = window.quizData[currentTopic].questions.length;
  var pct   = ((currentQ + 1) / total) * 100;
  document.getElementById('quizCounter').textContent   = (currentQ + 1) + ' / ' + total;
  document.getElementById('quizProgress').style.width  = pct + '%';
  var pb = document.getElementById('quizProgress').parentElement;
  if (pb) pb.setAttribute('aria-valuenow', pct);
  document.getElementById('quizQ').textContent          = q.q;
  document.getElementById('quizExplain').style.display  = 'none';
  document.getElementById('nextBtn').style.display      = 'none';
  document.getElementById('quizFeedback').textContent   = '';
  answered = false;
  document.getElementById('quizOpts').innerHTML = q.opts.map(function(o, i) {
    return '<button class="quiz-opt" onclick="selectOpt(' + i + ')" id="opt' + i + '" aria-label="Option ' + letters[i] + ': ' + o + '">' +
      '<span class="opt-letter" aria-hidden="true">' + letters[i] + '</span>' + o + '</button>';
  }).join('');
}

function selectOpt(idx) {
  if (answered) return;
  answered = true;
  var q    = window.quizData[currentTopic].questions[currentQ];
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
  explainEl.textContent   = '💡 ' + q.explain;
  explainEl.style.display = 'block';
  document.getElementById('nextBtn').style.display = 'inline-flex';
}

function nextQuestion() {
  currentQ++;
  if (currentQ >= window.quizData[currentTopic].questions.length) showResult();
  else renderQuestion();
}

function showResult() {
  document.getElementById('quizMain').style.display   = 'none';
  document.getElementById('quizResult').style.display = 'block';
  var total = window.quizData[currentTopic].questions.length;
  var pct   = (score / total) * 100;
  document.getElementById('scoreNum').textContent     = score + '/' + total;
  document.getElementById('quizProgress').style.width = '100%';
  document.getElementById('quizCounter').textContent  = total + ' / ' + total;
  var trophy = '💪', msg = '';
  if (pct === 100)    { trophy = '🏆'; msg = 'Perfect Score! You are exam-ready!'; }
  else if (pct >= 80) { trophy = '🎉'; msg = 'Excellent! Great preparation — keep it up!'; }
  else if (pct >= 60) { trophy = '👍'; msg = 'Good effort! Review the explanations and try again.'; }
  else if (pct >= 40) { trophy = '📚'; msg = 'Keep studying — you are getting there! Enroll for guided prep.'; }
  else                { trophy = '💪'; msg = 'Do not give up — enroll in our course for expert guidance!'; }
  document.getElementById('resultTrophy').textContent = trophy;
  document.getElementById('resultMsg').textContent    = msg;

  var shareText = 'I scored ' + score + '/' + total + ' in ' + window.quizData[currentTopic].name + ' on Global World Academy! 🧠\nTry it: ';
  var pageUrl   = window.location.href;
  document.getElementById('shareWa').href = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(shareText + pageUrl);
  document.getElementById('shareTg').href = 'https://t.me/share/url?url=' + encodeURIComponent(pageUrl) + '&text=' + encodeURIComponent(shareText);
  document.getElementById('shareBlock').style.display = 'block';
}

function restartQuiz() {
  currentQ = 0; score = 0; answered = false;
  document.getElementById('quizResult').style.display = 'none';
  document.getElementById('quizMain').style.display   = 'block';
  document.getElementById('shareBlock').style.display = 'none';
  renderQuestion();
}

document.addEventListener('DOMContentLoaded', init);
