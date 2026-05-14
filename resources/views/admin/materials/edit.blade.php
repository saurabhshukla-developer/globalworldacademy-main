@extends('admin.layouts.admin')
@section('title', 'Edit Material')
@section('page-title', '✏️ Edit Material')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.materials.index') }}">Materials</a> <span>/</span> Edit #{{ $material->id }}
</div>

<div class="card" style="max-width:720px;">
  <form method="POST" action="{{ route('admin.materials.update', $material) }}">
    @csrf @method('PUT')

    <div class="form-group">
      <label class="form-label">Title <span class="req">*</span></label>
      <input type="text" name="title" class="form-control" value="{{ old('title', $material->title) }}" required/>
    </div>

    <div class="form-group">
      <label class="form-label">Subject / Topic</label>
      <select name="topic_id" class="form-control {{ $errors->has('topic_id') ? 'is-invalid' : '' }}">
        <option value="">— None (general listing) —</option>
        @foreach($subjects as $subj)
          <optgroup label="{{ $subj->name }}">
            @foreach($subj->topics as $topic)
              <option value="{{ $topic->id }}" {{ (string) old('topic_id', $material->topic_id ?? '') === (string) $topic->id ? 'selected' : '' }}>
                {{ $topic->name }}
              </option>
            @endforeach
          </optgroup>
        @endforeach
      </select>
      <div class="form-hint">Optional. Groups this item on the public Study Materials page.</div>
      @error('topic_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
      <label class="form-label">Description <span class="req">*</span></label>
      <textarea name="description" rows="3" class="form-control" required>{{ old('description', $material->description) }}</textarea>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Icon (emoji)</label>
        <input type="text" name="icon" class="form-control" value="{{ old('icon', $material->icon) }}"/>
      </div>
      <div class="form-group">
        <label class="form-label">Icon Background</label>
        <select name="icon_bg_class" class="form-control">
          @foreach(['mi-blue'=>'Blue','mi-green'=>'Green','mi-gold'=>'Gold','mi-red'=>'Red','mi-purple'=>'Purple'] as $cls=>$lbl)
          <option value="{{ $cls }}" {{ old('icon_bg_class',$material->icon_bg_class)==$cls ? 'selected':'' }}>
            {{ $lbl }}
          </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Tags</label>
      <input type="text" name="tags" class="form-control"
             value="{{ old('tags', implode(', ', $material->tags ?? [])) }}"/>
      <div class="form-hint">Comma-separated</div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">External URL</label>
        <input type="url" name="external_url" class="form-control" value="{{ old('external_url', $material->external_url) }}"/>
      </div>
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $material->sort_order) }}" min="0"/>
      </div>
    </div>

    <div class="form-group">
      <div class="form-check">
        <input type="hidden" name="is_active" value="0"/>
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $material->is_active) ? 'checked' : '' }}/>
        <label for="is_active">Active (show on website)</label>
      </div>
    </div>

    <div style="display:flex;gap:12px;">
      <button type="submit" class="btn btn-primary">Update Material</button>
      <a href="{{ route('admin.materials.index') }}" class="btn btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection
