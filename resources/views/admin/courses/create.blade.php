@extends('admin.layouts.admin')
@section('title', 'Add Course')
@section('page-title', '+ Add Course')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.courses.index') }}">Courses</a> <span>/</span> Add
</div>

<div class="card" style="max-width:800px;">
  <form method="POST" action="{{ route('admin.courses.store') }}">
    @csrf

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Course Name <span class="req">*</span></label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
               value="{{ old('name') }}" placeholder="e.g. Varg 2 Science Mains Course" required/>
        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Exam Tag <span class="req">*</span></label>
        <input type="text" name="exam_tag" class="form-control" value="{{ old('exam_tag') }}" placeholder="e.g. MPTET Varg 2" required/>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Description <span class="req">*</span></label>
      <textarea name="description" rows="2" class="form-control" placeholder="Short course description..." required>{{ old('description') }}</textarea>
    </div>

    <div class="form-row-3">
      <div class="form-group">
        <label class="form-label">Thumbnail Class</label>
        <select name="thumb_class" class="form-control">
          @foreach(['ct1','ct2','ct3','ct4','ct5','ct6'] as $c)
          <option value="{{ $c }}" {{ old('thumb_class')== $c ? 'selected' : '' }}>{{ $c }}</option>
          @endforeach
        </select>
        <div class="form-hint">ct1=blue, ct2=navy, ct3=green, ct4=red, ct5=purple, ct6=gold</div>
      </div>
      <div class="form-group">
        <label class="form-label">Thumbnail Icon</label>
        <input type="text" name="thumb_icon" class="form-control" value="{{ old('thumb_icon', '📚') }}" placeholder="📚"/>
      </div>
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0"/>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Badge Text</label>
        <input type="text" name="badge" class="form-control" value="{{ old('badge') }}" placeholder="e.g. 🔥 Bestseller"/>
      </div>
      <div class="form-group">
        <label class="form-label">Badge Style</label>
        <select name="badge_style" class="form-control">
          <option value="badge-new" {{ old('badge_style')=='badge-new' ? 'selected' : '' }}>badge-new (blue)</option>
          <option value="badge-hot" {{ old('badge_style')=='badge-hot' ? 'selected' : '' }}>badge-hot (gold)</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Features <span class="req">*</span></label>
      <textarea name="features" rows="4" class="form-control" placeholder="One feature per line:&#10;Complete Video Classes&#10;PDF Notes Included" required>{{ old('features') }}</textarea>
      <div class="form-hint">One feature per line. These show as bullet points on the course card.</div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Price (₹) <span class="req">*</span></label>
        <input type="number" name="price" class="form-control" value="{{ old('price') }}" step="0.01" min="0" required/>
      </div>
      <div class="form-group">
        <label class="form-label">Old Price (₹)</label>
        <input type="number" name="old_price" class="form-control" value="{{ old('old_price') }}" step="0.01" min="0"/>
        <div class="form-hint">Leave blank for no strikethrough</div>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Buy URL <span class="req">*</span></label>
      <input type="url" name="buy_url" class="form-control" value="{{ old('buy_url', 'https://classplusapp.com/w/global-world-academy-xygeb') }}" required/>
    </div>

    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}/>
        <label for="is_active">Active (show on website)</label>
      </div>
    </div>

    <div style="display:flex;gap:12px;">
      <button type="submit" class="btn btn-primary">Save Course</button>
      <a href="{{ route('admin.courses.index') }}" class="btn btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection
