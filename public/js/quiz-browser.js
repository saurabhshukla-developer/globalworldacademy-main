/**
 * Global World Academy - Standalone subject/topic quiz browser.
 * Data is injected by Laravel as window.quizSubjects.
 */
(function () {
  'use strict';

  var PAGE_SIZE = 15;
  var LETTERS = ['A', 'B', 'C', 'D'];
  var subjects = window.quizSubjects || [];
  var labels = window.quizLabels || {};
  var lang = labels.lang || document.documentElement.lang || 'en';

  var currentSubjectId = null;
  var currentTopicId = null;
  var currentPage = 1;
  var answers = {};
  var completedTopics = {};
  var latestShare = null;
  var shouldSyncUrl = false;

  function byId(id) {
    return document.getElementById(id);
  }

  function localText(obj, key) {
    var hiKey = key + '_hi';
    return lang === 'hi' && obj && obj[hiKey] ? obj[hiKey] : (obj && obj[key]) || '';
  }

  function escapeHtml(value) {
    return String(value || '').replace(/[&<>"']/g, function (char) {
      return {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      }[char];
    });
  }

  function slugify(value) {
    return String(value || '')
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '');
  }

  function idMatches(actual, requested, name) {
    if (!requested) return false;
    return actual === requested ||
      actual.indexOf(requested + '-') === 0 ||
      slugify(name) === requested;
  }

  function findSubject(id) {
    return subjects.find(function (subject) {
      return idMatches(subject.id, id, subject.name);
    });
  }

  function findTopic(subject, id) {
    return subject && subject.topics.find(function (topic) {
      return idMatches(topic.id, id, topic.name);
    });
  }

  function currentContext() {
    var subject = findSubject(currentSubjectId);
    var topic = findTopic(subject, currentTopicId);
    return { subject: subject, topic: topic };
  }

  function topicButton(subject, topic) {
    var active = subject.id === currentSubjectId && topic.id === currentTopicId;
    var empty = !topic.questions || topic.questions.length === 0;
    return [
      '<button class="topic-btn ', active ? 'active ' : '', empty ? 'empty-topic' : '', '" type="button" data-subject-id="', escapeHtml(subject.id), '" data-topic-id="', escapeHtml(topic.id), '">',
      '<span class="topic-icon">', escapeHtml(topic.icon || '📝'), '</span>',
      '<span class="topic-copy"><span>', escapeHtml(localText(topic, 'name')), '</span>',
      '<small>', escapeHtml(topic.name_hi || topic.name || ''), '</small></span>',
      '<span class="topic-qcount">', (topic.questions || []).length, 'Q</span>',
      '</button>'
    ].join('');
  }

  function renderSidebar(filter) {
    var nav = byId('quizSidebarNav');
    if (!nav) return;

    var query = String(filter || '').trim().toLowerCase();
    var html = '';

    subjects.forEach(function (subject) {
      var subjectName = localText(subject, 'name').toLowerCase();
      var subjectHi = String(subject.name_hi || '').toLowerCase();
      var matchingTopics = (subject.topics || []).filter(function (topic) {
        if (!query) return true;
        return localText(topic, 'name').toLowerCase().indexOf(query) !== -1 ||
          String(topic.name_hi || '').toLowerCase().indexOf(query) !== -1 ||
          subjectName.indexOf(query) !== -1 ||
          subjectHi.indexOf(query) !== -1;
      });

      if (query && matchingTopics.length === 0) return;

      var active = subject.id === currentSubjectId;
      var open = active || !!query;
      html += [
        '<div class="subject-block">',
        '<button class="subject-btn ', active ? 'active' : '', '" type="button" data-subject-id="', escapeHtml(subject.id), '">',
        '<span class="subject-left"><span class="subject-icon">', escapeHtml(subject.icon || '📘'), '</span>',
        '<span class="subject-copy"><span>', escapeHtml(localText(subject, 'name')), '</span>',
        '<small>', escapeHtml(subject.name_hi || subject.name || ''), '</small></span></span>',
        '<span class="subject-meta"><span class="chevron ', open ? 'open' : '', '">›</span></span>',
        '</button>',
        '<div class="topic-list ', open ? 'open' : '', '">',
        matchingTopics.map(function (topic) { return topicButton(subject, topic); }).join(''),
        '</div>',
        '</div>'
      ].join('');
    });

    nav.innerHTML = html || '<div class="sidebar-empty">' + escapeHtml(labels.noResults || 'No results found.') + '</div>';
  }

  function syncUrl() {
    if (!shouldSyncUrl || !currentSubjectId || !currentTopicId) return;
    var params = new URLSearchParams();
    params.set('subject', currentSubjectId);
    params.set('topic', currentTopicId);
    if (currentPage > 1) params.set('page', currentPage);
    window.history.replaceState(null, '', window.location.pathname + '?' + params.toString());
  }

  function loadTopic(subjectId, topicId, page, syncUrlOnRender) {
    var subject = findSubject(subjectId);
    var topic = findTopic(subject, topicId);
    if (!subject || !topic) return;
    if (!topic.questions || topic.questions.length === 0) {
      currentSubjectId = subject.id;
      currentTopicId = null;
      renderSidebar(byId('quizSearch') ? byId('quizSearch').value : '');
      byId('emptyState').style.display = 'flex';
      byId('quizArea').style.display = 'none';
      var title = byId('emptyState').querySelector('h1');
      var copy = byId('emptyState').querySelector('p');
      if (title) title.textContent = localText(topic, 'name');
      if (copy) copy.textContent = 'No active questions are available for this topic yet.';
      return;
    }

    currentSubjectId = subjectId;
    currentTopicId = topicId;
    currentPage = Math.max(1, parseInt(page || 1, 10) || 1);
    shouldSyncUrl = !!syncUrlOnRender;
    latestShare = null;
    if (!answers[currentTopicId]) answers[currentTopicId] = {};

    renderSidebar(byId('quizSearch') ? byId('quizSearch').value : '');
    collapseTopicsOnMobile();
    renderQuiz();
  }

  function answeredCount(topicId) {
    return Object.keys(answers[topicId] || {}).length;
  }

  function renderQuiz() {
    var ctx = currentContext();
    if (!ctx.subject || !ctx.topic) return;

    var questions = ctx.topic.questions || [];
    var totalPages = Math.max(1, Math.ceil(questions.length / PAGE_SIZE));
    currentPage = Math.min(Math.max(currentPage, 1), totalPages);
    syncUrl();

    var start = (currentPage - 1) * PAGE_SIZE;
    var end = Math.min(start + PAGE_SIZE, questions.length);
    var answered = answeredCount(currentTopicId);
    var pct = questions.length ? Math.round((answered / questions.length) * 100) : 0;

    byId('emptyState').style.display = 'none';
    byId('quizArea').style.display = 'block';
    byId('breadSubject').textContent = localText(ctx.subject, 'name');
    byId('breadTopic').textContent = localText(ctx.topic, 'name');
    byId('topicIcon').textContent = ctx.topic.icon || '📝';
    byId('topicName').textContent = localText(ctx.topic, 'name');
    byId('statTotal').textContent = questions.length;
    byId('statAnswered').textContent = answered;
    byId('statPage').textContent = currentPage;
    byId('statPages').textContent = totalPages;
    byId('progressLabel').textContent = 'Q ' + (start + 1) + '-' + end + ' of ' + questions.length;
    byId('progressPct').textContent = pct + '% ' + (labels.complete || 'complete');
    byId('progressFill').style.width = pct + '%';
    byId('progressFill').parentElement.setAttribute('aria-valuenow', pct);

    renderQuestions(questions, start, end);
    renderPagination(totalPages);
    checkTopicComplete(questions);
  }

  function renderQuestions(questions, start, end) {
    var html = '';
    for (var i = start; i < end; i++) {
      var question = questions[i];
      var answer = answers[currentTopicId][i];
      var done = !!answer;
      html += [
        '<article class="question-card ', done ? (answer.correct ? 'answered-correct' : 'answered-wrong') : '', '" id="question-', i, '">',
        '<div class="q-header"><div class="q-num">', i + 1, '</div><div class="q-text">', escapeHtml(localText(question, 'q')), '</div></div>',
        '<div class="q-options">',
        (question.opts || []).map(function (option, optionIndex) {
          var cls = '';
          if (done && optionIndex === question.ans) cls = 'correct';
          else if (done && optionIndex === answer.selected) cls = 'wrong';
          return [
            '<button class="q-opt ', cls, '" type="button" ', done ? 'disabled' : '', ' data-question-index="', i, '" data-option-index="', optionIndex, '">',
            '<span class="opt-letter">', LETTERS[optionIndex] || optionIndex + 1, '</span>',
            '<span>', escapeHtml(option), '</span>',
            '</button>'
          ].join('');
        }).join(''),
        '</div>',
        '<div class="q-result-row ', done ? 'show' : '', '">',
        done ? resultText(question, answer) : '',
        '</div>',
        '<div class="q-explain ', done ? 'show' : '', '">',
        done ? '💡 <strong>' + escapeHtml(labels.explanation || 'Explanation:') + '</strong> ' + escapeHtml(localText(question, 'explain')) : '',
        '</div>',
        '</article>'
      ].join('');
    }
    byId('questionsList').innerHTML = html;
  }

  function resultText(question, answer) {
    if (answer.correct) {
      return '<span class="q-result-correct">✅ ' + escapeHtml(labels.correct || 'Correct!') + '</span>';
    }
    return '<span class="q-result-wrong">❌ ' + escapeHtml(labels.wrong || 'Wrong! Correct:') + ' <strong>' + escapeHtml(LETTERS[question.ans] || question.ans + 1) + '</strong></span>';
  }

  function renderPagination(totalPages) {
    var html = '';
    if (totalPages > 1) {
      html += '<button class="page-btn" type="button" data-page="' + (currentPage - 1) + '" ' + (currentPage === 1 ? 'disabled' : '') + '>‹</button>';
      for (var page = 1; page <= totalPages; page++) {
        html += '<button class="page-btn ' + (page === currentPage ? 'active' : '') + '" type="button" data-page="' + page + '">' + page + '</button>';
      }
      html += '<button class="page-btn" type="button" data-page="' + (currentPage + 1) + '" ' + (currentPage === totalPages ? 'disabled' : '') + '>›</button>';
    }
    byId('pagination').innerHTML = html;
  }

  function pick(questionIndex, optionIndex) {
    var ctx = currentContext();
    if (!ctx.topic || answers[currentTopicId][questionIndex]) return;
    var question = ctx.topic.questions[questionIndex];
    answers[currentTopicId][questionIndex] = {
      selected: optionIndex,
      correct: optionIndex === question.ans
    };
    renderQuiz();
    var card = byId('question-' + questionIndex);
    if (card) card.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }

  function checkTopicComplete(questions) {
    var panel = byId('scorePanel');
    if (answeredCount(currentTopicId) < questions.length) {
      panel.classList.remove('show');
      return;
    }

    var correct = 0;
    questions.forEach(function (_question, index) {
      if (answers[currentTopicId][index] && answers[currentTopicId][index].correct) correct++;
    });
    var total = questions.length;
    var pct = total ? Math.round((correct / total) * 100) : 0;
    var icon = '💪';
    var message = labels.scoreLow || 'Keep practicing.';
    if (pct === 100) {
      icon = '🏆';
      message = labels.scorePerfect || 'Perfect score!';
    } else if (pct >= 80) {
      icon = '🎉';
      message = labels.scoreGreat || 'Excellent!';
    } else if (pct >= 60) {
      icon = '👍';
      message = labels.scoreGood || 'Good effort!';
    }

    byId('scoreIcon').textContent = icon;
    byId('scoreNum').textContent = correct;
    byId('scoreDen').textContent = '/' + total;
    byId('scoreMsg').textContent = message;
    updateShare(correct, total, pct);
    panel.classList.add('show');

    if (!completedTopics[currentTopicId]) {
      completedTopics[currentTopicId] = true;
      panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  function shareUrl() {
    var url = new URL(window.location.href);
    url.search = '';
    url.searchParams.set('subject', currentSubjectId);
    url.searchParams.set('topic', currentTopicId);
    if (currentPage > 1) url.searchParams.set('page', currentPage);
    return url.toString();
  }

  function updateShare(correct, total, pct) {
    var ctx = currentContext();
    var url = shareUrl();
    var text = [
      labels.shareTitle || 'Global World Academy Quiz',
      localText(ctx.subject, 'name') + ' > ' + localText(ctx.topic, 'name'),
      'Total score: ' + correct + '/' + total + ' (' + pct + '%)',
      (labels.tryQuiz || 'Try this quiz:') + ' ' + url
    ].join('\n');
    latestShare = { url: url, text: text };
    byId('scoreShareText').textContent = localText(ctx.topic, 'name') + ': ' + correct + '/' + total + ' correct (' + pct + '%).';
    byId('scoreShareWa').href = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(text);
    byId('scoreShareTg').href = 'https://t.me/share/url?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text);
  }

  function copyShareLink() {
    var value = latestShare ? latestShare.url : shareUrl();
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(value).then(showCopyToast).catch(function () { fallbackCopy(value); });
      return;
    }
    fallbackCopy(value);
  }

  function fallbackCopy(value) {
    var input = document.createElement('textarea');
    input.value = value;
    input.style.cssText = 'position:fixed;opacity:0;top:0;left:0;';
    document.body.appendChild(input);
    input.focus();
    input.select();
    try { document.execCommand('copy'); showCopyToast(); } catch (e) {}
    document.body.removeChild(input);
  }

  function showCopyToast() {
    var toast = byId('scoreShareToast');
    toast.style.display = 'block';
    clearTimeout(showCopyToast.timer);
    showCopyToast.timer = setTimeout(function () {
      toast.style.display = 'none';
    }, 2200);
  }

  function retryQuiz() {
    answers[currentTopicId] = {};
    completedTopics[currentTopicId] = false;
    currentPage = 1;
    byId('scorePanel').classList.remove('show');
    renderQuiz();
  }

  function collapseTopicsOnMobile() {
    if (window.matchMedia('(max-width: 900px)').matches && currentTopicId) {
      byId('quizSidebar').classList.add('topics-collapsed');
    }
  }

  function showTopics() {
    byId('quizSidebar').classList.remove('topics-collapsed');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function initFromUrl() {
    var params = new URLSearchParams(window.location.search);
    var subjectId = params.get('subject');
    var topicId = params.get('topic');
    var page = parseInt(params.get('page') || '1', 10) || 1;
    var subject = findSubject(subjectId);
    var topic = findTopic(subject, topicId);

    if (subject && topic) {
      loadTopic(subject.id, topic.id, page, false);
    } else {
      currentSubjectId = null;
      currentTopicId = null;
      byId('emptyState').style.display = 'flex';
      byId('quizArea').style.display = 'none';
      renderSidebar('');
    }
  }

  function bindEvents() {
    var search = byId('quizSearch');
    var showTopicsBtn = byId('showTopicsBtn');
    var retryQuizBtn = byId('retryQuizBtn');
    var copyScoreLink = byId('copyScoreLink');
    var sidebarNav = byId('quizSidebarNav');
    var questionsList = byId('questionsList');
    var pagination = byId('pagination');

    if (search) search.addEventListener('input', function (event) {
      renderSidebar(event.target.value);
    });
    if (showTopicsBtn) showTopicsBtn.addEventListener('click', showTopics);
    if (retryQuizBtn) retryQuizBtn.addEventListener('click', retryQuiz);
    if (copyScoreLink) copyScoreLink.addEventListener('click', copyShareLink);

    if (sidebarNav) sidebarNav.addEventListener('click', function (event) {
      var subjectBtn = event.target.closest('.subject-btn');
      var topicBtn = event.target.closest('.topic-btn');
      if (topicBtn) {
        loadTopic(topicBtn.dataset.subjectId, topicBtn.dataset.topicId, 1, true);
        return;
      }
      if (subjectBtn) {
        var list = subjectBtn.nextElementSibling;
        var chevron = subjectBtn.querySelector('.chevron');
        if (list) list.classList.toggle('open');
        if (chevron) chevron.classList.toggle('open');
      }
    });

    if (questionsList) questionsList.addEventListener('click', function (event) {
      var option = event.target.closest('.q-opt');
      if (!option || option.disabled) return;
      pick(parseInt(option.dataset.questionIndex, 10), parseInt(option.dataset.optionIndex, 10));
    });

    if (pagination) pagination.addEventListener('click', function (event) {
      var button = event.target.closest('.page-btn');
      if (!button || button.disabled) return;
      currentPage = parseInt(button.dataset.page, 10);
      shouldSyncUrl = true;
      renderQuiz();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    renderSidebar('');
    bindEvents();
    initFromUrl();
  });
})();
