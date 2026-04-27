@extends('admin.layouts.admin')
@section('title', 'Edit Course')
@section('page-title', '✏️ Edit Course')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.courses.index') }}">Courses</a> <span>/</span> Edit #{{ $course->id }}
</div>

<div class="card" style="max-width:800px;">
  <form method="POST" action="{{ route('admin.courses.update', $course) }}">
    @csrf @method('PUT')

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Course Name <span class="req">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $course->name) }}" required/>
      </div>
      <div class="form-group">
        <label class="form-label">Exam Tag <span class="req">*</span></label>
        <input type="text" name="exam_tag" class="form-control" value="{{ old('exam_tag', $course->exam_tag) }}" required/>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Description <span class="req">*</span></label>
      <textarea name="description" rows="2" class="form-control" required>{{ old('description', $course->description) }}</textarea>
    </div>

    <div class="form-row-3">
      <div class="form-group">
        <label class="form-label">Thumbnail Class</label>
        <select name="thumb_class" class="form-control">
          @foreach(['ct1','ct2','ct3','ct4','ct5','ct6'] as $c)
          <option value="{{ $c }}" {{ old('thumb_class',$course->thumb_class)==$c ? 'selected' : '' }}>{{ $c }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Thumbnail Icon</label>
        <input type="text" name="thumb_icon" class="form-control" value="{{ old('thumb_icon', $course->thumb_icon) }}"/>
      </div>
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $course->sort_order) }}" min="0"/>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Badge Text</label>
        <input type="text" name="badge" class="form-control" value="{{ old('badge', $course->badge) }}"/>
      </div>
      <div class="form-group">
        <label class="form-label">Badge Style</label>
        <select name="badge_style" class="form-control">
          <option value="badge-new" {{ old('badge_style',$course->badge_style)=='badge-new' ? 'selected' : '' }}>badge-new (blue)</option>
          <option value="badge-hot" {{ old('badge_style',$course->badge_style)=='badge-hot' ? 'selected' : '' }}>badge-hot (gold)</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Features <span class="req">*</span></label>
      <textarea name="features" rows="4" class="form-control" required>{{ old('features', implode("\n", $course->features ?? [])) }}</textarea>
      <div class="form-hint">One feature per line.</div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Price (₹) <span class="req">*</span></label>
        <input type="number" name="price" class="form-control" value="{{ old('price', $course->price) }}" step="0.01" min="0" required/>
      </div>
      <div class="form-group">
        <label class="form-label">Old Price (₹)</label>
        <input type="number" name="old_price" class="form-control" value="{{ old('old_price', $course->old_price) }}" step="0.01" min="0"/>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Buy URL <span class="req">*</span></label>
      <input type="url" name="buy_url" class="form-control" value="{{ old('buy_url', $course->buy_url) }}" required/>
    </div>

    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ $course->is_active ? 'checked' : '' }}/>
        <label for="is_active">Active (show on website)</label>
      </div>
    </div>

    <div style="display:flex;gap:12px;">
      <button type="submit" class="btn btn-primary">Update Course</button>
      <a href="{{ route('admin.courses.index') }}" class="btn btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection
