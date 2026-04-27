@extends('admin.layouts.admin')
@section('title','Edit Category')
@section('page-title','✏️ Edit Category')
@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.quiz-categories.index') }}">Categories</a> <span>/</span> Edit #{{ $quizCategory->id }}
</div>
<div class="card" style="max-width:680px;">
  <form method="POST" action="{{ route('admin.quiz-categories.update', $quizCategory) }}">
    @csrf @method('PUT')
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Name (English) <span class="req">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name',$quizCategory->name) }}" required/>
      </div>
      <div class="form-group">
        <label class="form-label">Name (Hindi)</label>
        <input type="text" name="name_hi" class="form-control" value="{{ old('name_hi',$quizCategory->name_hi) }}"
               style="font-family:'Noto Sans Devanagari',sans-serif;"/>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Description (English)</label>
        <textarea name="description" class="form-control" rows="2">{{ old('description',$quizCategory->description) }}</textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Description (Hindi)</label>
        <textarea name="description_hi" class="form-control" rows="2"
                  style="font-family:'Noto Sans Devanagari',sans-serif;">{{ old('description_hi',$quizCategory->description_hi) }}</textarea>
      </div>
    </div>
    <div class="form-row-3">
      <div class="form-group">
        <label class="form-label">Icon (emoji) <span class="req">*</span></label>
        <input type="text" name="icon" class="form-control" value="{{ old('icon',$quizCategory->icon) }}" required/>
      </div>
      <div class="form-group">
        <label class="form-label">Color <span class="req">*</span></label>
        <div style="display:flex;gap:8px;align-items:center;">
          <input type="color" name="color" value="{{ old('color',$quizCategory->color) }}" style="width:48px;height:40px;border-radius:8px;border:1.5px solid var(--border);cursor:pointer;padding:2px;"/>
          <input type="text" value="{{ old('color',$quizCategory->color) }}" class="form-control" style="font-family:monospace;" oninput="document.querySelector('input[type=color]').value=this.value"/>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$quizCategory->sort_order) }}" min="0"/>
      </div>
    </div>
    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ $quizCategory->is_active ? 'checked':'' }}/>
        <label for="is_active">Active</label>
      </div>
    </div>
    <div style="display:flex;gap:12px;">
      <button type="submit" class="btn btn-primary">Update Category</button>
      <a href="{{ route('admin.quiz-categories.index') }}" class="btn btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection
