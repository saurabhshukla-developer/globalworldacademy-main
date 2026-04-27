@extends('admin.layouts.admin')
@section('title','Edit Question')
@section('page-title','✏️ Edit Question')
@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.quiz.index') }}">Questions</a> <span>/</span> Edit #{{ $quiz->id }}
</div>
<div class="card" style="max-width:820px;">
  <form method="POST" action="{{ route('admin.quiz.update', $quiz) }}">
    @csrf @method('PUT')

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Category</label>
        <select id="catSelect" class="form-control" onchange="filterTopics(this.value)">
          <option value="">-- All --</option>
          @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ $quiz->quizTopic?->category_id==$cat->id ? 'selected':'' }}>
            {{ $cat->icon }} {{ $cat->name }}
          </option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Topic <span class="req">*</span></label>
        <select name="topic_id" id="topicSelect" class="form-control" required>
          @foreach($categories as $cat)
            @foreach($cat->topics as $t)
            <option value="{{ $t->id }}" data-cat="{{ $cat->id }}"
                    {{ old('topic_id',$quiz->topic_id)==$t->id ? 'selected':'' }}>
              {{ $t->icon }} {{ $t->name }}
            </option>
            @endforeach
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Question (English) <span class="req">*</span></label>
        <textarea name="question" rows="3" class="form-control" required>{{ old('question',$quiz->question) }}</textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Question (Hindi)</label>
        <textarea name="question_hi" rows="3" class="form-control"
                  style="font-family:'Noto Sans Devanagari',sans-serif;">{{ old('question_hi',$quiz->question_hi) }}</textarea>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Answer Options <span class="req">*</span></label>
      @foreach(['A','B','C','D'] as $i => $letter)
      <div class="option-row">
        <div class="option-letter">{{ $letter }}</div>
        <input type="text" name="options[{{ $i }}]" class="form-control"
               value="{{ old("options.$i", $quiz->options[$i] ?? '') }}" required/>
      </div>
      @endforeach
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Correct Answer <span class="req">*</span></label>
        <select name="answer_index" class="form-control" required>
          @foreach(['A'=>0,'B'=>1,'C'=>2,'D'=>3] as $l=>$idx)
          <option value="{{ $idx }}" {{ old('answer_index',$quiz->answer_index)==$idx ? 'selected':'' }}>Option {{ $l }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$quiz->sort_order) }}" min="0"/>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Explanation (English)</label>
        <textarea name="explanation" rows="2" class="form-control">{{ old('explanation',$quiz->explanation) }}</textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Explanation (Hindi)</label>
        <textarea name="explanation_hi" rows="2" class="form-control"
                  style="font-family:'Noto Sans Devanagari',sans-serif;">{{ old('explanation_hi',$quiz->explanation_hi) }}</textarea>
      </div>
    </div>

    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ $quiz->is_active ? 'checked':'' }}/>
        <label for="is_active">Active</label>
      </div>
    </div>

    <div style="display:flex;gap:12px;">
      <button type="submit" class="btn btn-primary">Update Question</button>
      <a href="{{ route('admin.quiz.index') }}" class="btn btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
function filterTopics(catId) {
  document.querySelectorAll('#topicSelect option[data-cat]').forEach(function(o) {
    o.style.display = (!catId || o.dataset.cat === catId) ? '' : 'none';
  });
}
</script>
@endpush
