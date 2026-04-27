@extends('admin.layouts.admin')
@section('title', 'Edit Question')
@section('page-title', '✏️ Edit Question')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.quiz.index') }}">Quiz Questions</a> <span>/</span> Edit #{{ $quiz->id }}
</div>

<div class="card" style="max-width:760px;">
  <form method="POST" action="{{ route('admin.quiz.update', $quiz) }}">
    @csrf @method('PUT')

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Topic <span class="req">*</span></label>
        <select name="topic" class="form-control" required>
          <option value="science"   {{ $quiz->topic=='science'   ? 'selected' : '' }}>🔬 Science</option>
          <option value="child_dev" {{ $quiz->topic=='child_dev' ? 'selected' : '' }}>👶 Child Development</option>
          <option value="gk"        {{ $quiz->topic=='gk'        ? 'selected' : '' }}>🌍 General Knowledge</option>
          <option value="mp"        {{ $quiz->topic=='mp'        ? 'selected' : '' }}>🗺️ MP GK</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $quiz->sort_order) }}" min="0"/>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Question <span class="req">*</span></label>
      <textarea name="question" rows="3" class="form-control" required>{{ old('question', $quiz->question) }}</textarea>
    </div>

    <div class="form-group">
      <label class="form-label">Answer Options <span class="req">*</span></label>
      @foreach(['A','B','C','D'] as $i => $letter)
      <div class="option-row">
        <div class="option-letter">{{ $letter }}</div>
        <input type="text" name="options[{{ $i }}]"
               class="form-control"
               value="{{ old("options.$i", $quiz->options[$i] ?? '') }}"
               placeholder="Option {{ $letter }}" required/>
      </div>
      @endforeach
    </div>

    <div class="form-group">
      <label class="form-label">Correct Answer <span class="req">*</span></label>
      <select name="answer_index" class="form-control" required>
        @foreach(['A'=>0,'B'=>1,'C'=>2,'D'=>3] as $letter => $idx)
        <option value="{{ $idx }}" {{ (old('answer_index', $quiz->answer_index)==$idx) ? 'selected' : '' }}>
          Option {{ $letter }}
        </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label class="form-label">Explanation</label>
      <textarea name="explanation" rows="3" class="form-control">{{ old('explanation', $quiz->explanation) }}</textarea>
    </div>

    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ $quiz->is_active ? 'checked' : '' }}/>
        <label for="is_active">Active (show in quiz)</label>
      </div>
    </div>

    <div style="display:flex;gap:12px;">
      <button type="submit" class="btn btn-primary">Update Question</button>
      <a href="{{ route('admin.quiz.index') }}" class="btn btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection
