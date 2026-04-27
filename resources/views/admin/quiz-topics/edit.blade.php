@extends('admin.layouts.admin')
@section('title','Edit Topic')
@section('page-title','✏️ Edit Topic')
@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.quiz-topics.index') }}">Topics</a> <span>/</span> Edit #{{ $quizTopic->id }}
</div>
<div class="card" style="max-width:680px;">
  <form method="POST" action="{{ route('admin.quiz-topics.update', $quizTopic) }}">
    @csrf @method('PUT')
    <div class="form-group">
      <label class="form-label">Category <span class="req">*</span></label>
      <select name="category_id" class="form-control" required>
        @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ old('category_id',$quizTopic->category_id)==$cat->id ? 'selected':'' }}>
          {{ $cat->icon }} {{ $cat->name }} {{ $cat->name_hi ? '('.$cat->name_hi.')':'' }}
        </option>
        @endforeach
      </select>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Name (English) <span class="req">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name',$quizTopic->name) }}" required/>
      </div>
      <div class="form-group">
        <label class="form-label">Name (Hindi)</label>
        <input type="text" name="name_hi" class="form-control" value="{{ old('name_hi',$quizTopic->name_hi) }}"
               style="font-family:'Noto Sans Devanagari',sans-serif;"/>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="2">{{ old('description',$quizTopic->description) }}</textarea>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Icon <span class="req">*</span></label>
        <input type="text" name="icon" class="form-control" value="{{ old('icon',$quizTopic->icon) }}" required/>
      </div>
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$quizTopic->sort_order) }}" min="0"/>
      </div>
    </div>
    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ $quizTopic->is_active ? 'checked':'' }}/>
        <label for="is_active">Active</label>
      </div>
    </div>
    <div style="display:flex;gap:12px;">
      <button type="submit" class="btn btn-primary">Update Topic</button>
      <a href="{{ route('admin.quiz-topics.index') }}" class="btn btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection
