@extends('admin.layouts.admin')
@section('title', 'Add Question')
@section('page-title', '+ Add Quiz Question')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.quiz.index') }}">Quiz Questions</a> <span>/</span> Add
</div>

<div class="card" style="max-width:760px;">
  <form method="POST" action="{{ route('admin.quiz.store') }}">
    @csrf

    <div class="form-row">
      <div class="form-group">
        <label class="form-label" for="topic">Topic <span class="req">*</span></label>
        <select name="topic" id="topic" class="form-control {{ $errors->has('topic') ? 'is-invalid' : '' }}" required>
          <option value="">-- Select Topic --</option>
          <option value="science"   {{ old('topic')=='science'   ? 'selected' : '' }}>🔬 Science</option>
          <option value="child_dev" {{ old('topic')=='child_dev' ? 'selected' : '' }}>👶 Child Development</option>
          <option value="gk"        {{ old('topic')=='gk'        ? 'selected' : '' }}>🌍 General Knowledge</option>
          <option value="mp"        {{ old('topic')=='mp'        ? 'selected' : '' }}>🗺️ MP GK</option>
        </select>
        @error('topic')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="form-group">
        <label class="form-label" for="sort_order">Sort Order</label>
        <input type="number" id="sort_order" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0"/>
        <div class="form-hint">Lower number = shown first</div>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label" for="question">Question <span class="req">*</span></label>
      <textarea name="question" id="question" rows="3"
                class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}"
                placeholder="Enter the question text..." required>{{ old('question') }}</textarea>
      @error('question')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
      <label class="form-label">Answer Options <span class="req">*</span></label>
      <div class="form-hint" style="margin-bottom:10px;">Enter all 4 options. Select the correct answer below.</div>
      @foreach(['A','B','C','D'] as $i => $letter)
      <div class="option-row">
        <div class="option-letter">{{ $letter }}</div>
        <input type="text" name="options[{{ $i }}]"
               class="form-control {{ $errors->has("options.$i") ? 'is-invalid' : '' }}"
               value="{{ old("options.$i") }}"
               placeholder="Option {{ $letter }}" required/>
      </div>
      @endforeach
    </div>

    <div class="form-group">
      <label class="form-label" for="answer_index">Correct Answer <span class="req">*</span></label>
      <select name="answer_index" id="answer_index" class="form-control" required>
        @foreach(['A'=>0,'B'=>1,'C'=>2,'D'=>3] as $letter => $idx)
        <option value="{{ $idx }}" {{ old('answer_index')==$idx ? 'selected' : '' }}>Option {{ $letter }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label class="form-label" for="explanation">Explanation</label>
      <textarea name="explanation" id="explanation" rows="3"
                class="form-control" placeholder="Explain why the correct answer is correct...">{{ old('explanation') }}</textarea>
    </div>

    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}/>
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
