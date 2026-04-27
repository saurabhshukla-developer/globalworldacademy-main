@extends('admin.layouts.admin')
@section('title','Add Topic')
@section('page-title','+ Add Quiz Topic')
@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.quiz-topics.index') }}">Topics</a> <span>/</span> Add
</div>
<div class="card" style="max-width:680px;">
  <form method="POST" action="{{ route('admin.quiz-topics.store') }}">
    @csrf
    <div class="form-group">
      <label class="form-label">Category <span class="req">*</span></label>
      <select name="category_id" class="form-control {{ $errors->has('category_id') ? 'is-invalid':'' }}" required>
        <option value="">-- Select Category --</option>
        @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id ? 'selected':'' }}>
          {{ $cat->icon }} {{ $cat->name }} {{ $cat->name_hi ? '('.$cat->name_hi.')':'' }}
        </option>
        @endforeach
      </select>
      @error('category_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Topic Name (English) <span class="req">*</span></label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}"
               value="{{ old('name') }}" placeholder="e.g. General Science" required/>
        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Topic Name (Hindi)</label>
        <input type="text" name="name_hi" class="form-control" value="{{ old('name_hi') }}"
               placeholder="e.g. सामान्य विज्ञान"
               style="font-family:'Noto Sans Devanagari',sans-serif;"/>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="2" placeholder="Optional description">{{ old('description') }}</textarea>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Icon (emoji) <span class="req">*</span></label>
        <input type="text" name="icon" class="form-control" value="{{ old('icon','📝') }}" required/>
      </div>
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',0) }}" min="0"/>
      </div>
    </div>
    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" id="is_active" name="is_active" value="1" checked/>
        <label for="is_active">Active</label>
      </div>
    </div>
    <div style="display:flex;gap:12px;">
      <button type="submit" class="btn btn-primary">Save Topic</button>
      <a href="{{ route('admin.quiz-topics.index') }}" class="btn btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection
