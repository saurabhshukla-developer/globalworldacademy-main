@extends('admin.layouts.admin')
@section('title','Add Question')
@section('page-title','+ Add Quiz Question')
@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.quiz.index') }}">Questions</a> <span>/</span> Add
</div>
<div class="card" style="max-width:820px;">
  <form method="POST" action="{{ route('admin.quiz.store') }}">
    @csrf

    {{-- Category → Topic selector --}}
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Category <span class="req">*</span></label>
        <select id="catSelect" class="form-control" onchange="filterTopics(this.value)">
          <option value="">-- Select Category First --</option>
          @foreach($categories as $cat)
          <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Topic <span class="req">*</span></label>
        <select name="topic_id" id="topicSelect" class="form-control {{ $errors->has('topic_id') ? 'is-invalid':'' }}" required>
          <option value="">-- Select Topic --</option>
          @foreach($categories as $cat)
            @foreach($cat->topics as $t)
            <option value="{{ $t->id }}" data-cat="{{ $cat->id }}" {{ old('topic_id')==$t->id ? 'selected':'' }}>
              {{ $t->icon }} {{ $t->name }}
            </option>
            @endforeach
          @endforeach
        </select>
        @error('topic_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    {{-- Bilingual Question --}}
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Question (English) <span class="req">*</span></label>
        <textarea name="question" rows="3" class="form-control {{ $errors->has('question') ? 'is-invalid':'' }}"
                  placeholder="Enter question in English..." required>{{ old('question') }}</textarea>
        @error('question')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Question (Hindi)</label>
        <textarea name="question_hi" rows="3" class="form-control"
                  placeholder="प्रश्न हिंदी में लिखें..."
                  style="font-family:'Noto Sans Devanagari',sans-serif;">{{ old('question_hi') }}</textarea>
      </div>
    </div>

    {{-- Options --}}
    <div class="form-group">
      <label class="form-label">Answer Options <span class="req">*</span></label>
      <div class="form-hint" style="margin-bottom:10px;">Enter all 4 options. Select correct answer below.</div>
      @foreach(['A','B','C','D'] as $i => $letter)
      <div class="option-row">
        <div class="option-letter">{{ $letter }}</div>
        <input type="text" name="options[{{ $i }}]"
               class="form-control {{ $errors->has("options.$i") ? 'is-invalid':'' }}"
               value="{{ old("options.$i") }}" placeholder="Option {{ $letter }}" required/>
      </div>
      @endforeach
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Correct Answer <span class="req">*</span></label>
        <select name="answer_index" class="form-control" required>
          @foreach(['A'=>0,'B'=>1,'C'=>2,'D'=>3] as $l=>$idx)
          <option value="{{ $idx }}" {{ old('answer_index')==$idx ? 'selected':'' }}>Option {{ $l }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',0) }}" min="0"/>
      </div>
    </div>

    {{-- Bilingual Explanation --}}
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Explanation (English)</label>
        <textarea name="explanation" rows="2" class="form-control">{{ old('explanation') }}</textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Explanation (Hindi)</label>
        <textarea name="explanation_hi" rows="2" class="form-control"
                  style="font-family:'Noto Sans Devanagari',sans-serif;">{{ old('explanation_hi') }}</textarea>
      </div>
    </div>

    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active',true) ? 'checked':'' }}/>
        <label for="is_active">Active (show in quiz)</label>
      </div>
    </div>

    <div style="display:flex;gap:12px;">
      <button type="submit" class="btn btn-primary">Save Question</button>
      <a href="{{ route('admin.quiz.index') }}" class="btn btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
function filterTopics(catId) {
  var opts = document.querySelectorAll('#topicSelect option[data-cat]');
  opts.forEach(function(o) {
    o.style.display = (!catId || o.dataset.cat === catId) ? '' : 'none';
  });
  document.getElementById('topicSelect').value = '';
}
// Pre-select category if topic is already selected (edit mode / old())
(function() {
  var sel = document.getElementById('topicSelect');
  if (sel.value) {
    var opt = sel.querySelector('option[value="' + sel.value + '"]');
    if (opt) document.getElementById('catSelect').value = opt.dataset.cat;
  }
})();
</script>
@endpush
