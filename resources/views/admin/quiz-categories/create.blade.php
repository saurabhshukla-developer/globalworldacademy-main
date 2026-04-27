@extends('admin.layouts.admin')
@section('title','Add Category')
@section('page-title','+ Add Quiz Category')
@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.quiz-categories.index') }}">Categories</a> <span>/</span> Add
</div>
<div class="card" style="max-width:680px;">
  <form method="POST" action="{{ route('admin.quiz-categories.store') }}">
    @csrf
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Name (English) <span class="req">*</span></label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}"
               value="{{ old('name') }}" placeholder="e.g. Science" required/>
        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Name (Hindi)</label>
        <input type="text" name="name_hi" class="form-control"
               value="{{ old('name_hi') }}" placeholder="e.g. विज्ञान"
               style="font-family:'Noto Sans Devanagari',sans-serif;"/>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Description (English)</label>
        <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Description (Hindi)</label>
        <textarea name="description_hi" class="form-control" rows="2"
                  style="font-family:'Noto Sans Devanagari',sans-serif;">{{ old('description_hi') }}</textarea>
      </div>
    </div>
    <div class="form-row-3">
      <div class="form-group">
        <label class="form-label">Icon (emoji) <span class="req">*</span></label>
        <input type="text" name="icon" class="form-control" value="{{ old('icon','📝') }}" required/>
      </div>
      <div class="form-group">
        <label class="form-label">Color (hex) <span class="req">*</span></label>
        <div style="display:flex;gap:8px;align-items:center;">
          <input type="color" name="color" value="{{ old('color','#1155cc') }}" style="width:48px;height:40px;border-radius:8px;border:1.5px solid var(--border);cursor:pointer;padding:2px;"/>
          <input type="text" id="colorHex" value="{{ old('color','#1155cc') }}" class="form-control" style="font-family:monospace;" oninput="document.querySelector('input[type=color]').value=this.value"/>
        </div>
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
      <button type="submit" class="btn btn-primary">Save Category</button>
      <a href="{{ route('admin.quiz-categories.index') }}" class="btn btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection
