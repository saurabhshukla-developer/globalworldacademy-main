@extends('admin.layouts.admin')
@section('title', 'Add Material')
@section('page-title', '+ Add Study Material')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.materials.index') }}">Materials</a> <span>/</span> Add
</div>

<div class="card" style="max-width:720px;">
  <form method="POST" action="{{ route('admin.materials.store') }}">
    @csrf

    <div class="form-group">
      <label class="form-label">Title <span class="req">*</span></label>
      <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
             value="{{ old('title') }}" placeholder="e.g. MPTET Varg 2 Science – Chapter Notes" required/>
      @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
      <label class="form-label">Subject / Topic</label>
      <select name="topic_id" class="form-control {{ $errors->has('topic_id') ? 'is-invalid' : '' }}">
        <option value="">— None (general listing) —</option>
        @foreach($subjects as $subj)
          <optgroup label="{{ $subj->name }}">
            @foreach($subj->topics as $topic)
              <option value="{{ $topic->id }}" {{ (string) old('topic_id', '') === (string) $topic->id ? 'selected' : '' }}>
                {{ $topic->name }}
              </option>
            @endforeach
          </optgroup>
        @endforeach
      </select>
      <div class="form-hint">Optional. Used to group this item on the public Study Materials page (same subjects/topics as the quiz).</div>
      @error('topic_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
      <label class="form-label">Description <span class="req">*</span></label>
      <textarea name="description" rows="3" class="form-control" placeholder="Describe what this material contains..." required>{{ old('description') }}</textarea>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Icon (emoji)</label>
        <input type="text" name="icon" class="form-control" value="{{ old('icon', '📘') }}" placeholder="📘"/>
      </div>
      <div class="form-group">
        <label class="form-label">Icon Background</label>
        <select name="icon_bg_class" class="form-control">
          <option value="mi-blue"   {{ old('icon_bg_class')=='mi-blue'   ? 'selected':'' }}>mi-blue (Blue)</option>
          <option value="mi-green"  {{ old('icon_bg_class')=='mi-green'  ? 'selected':'' }}>mi-green (Green)</option>
          <option value="mi-gold"   {{ old('icon_bg_class')=='mi-gold'   ? 'selected':'' }}>mi-gold (Gold)</option>
          <option value="mi-red"    {{ old('icon_bg_class')=='mi-red'    ? 'selected':'' }}>mi-red (Red)</option>
          <option value="mi-purple" {{ old('icon_bg_class')=='mi-purple' ? 'selected':'' }}>mi-purple (Purple)</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Tags</label>
      <input type="text" name="tags" class="form-control" value="{{ old('tags', 'PDF, Free') }}" placeholder="PDF, Hindi + English, Free"/>
      <div class="form-hint">Comma-separated tags shown on the card</div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">External URL</label>
        <input type="url" name="external_url" class="form-control" value="{{ old('external_url') }}" placeholder="https://drive.google.com/..."/>
        <div class="form-hint">Google Drive or any direct download URL</div>
      </div>
      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0"/>
      </div>
    </div>

    <div class="form-group">
      <div class="form-check">
        <input type="hidden" name="is_active" value="0"/>
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}/>
        <label for="is_active">Active (show on website)</label>
      </div>
    </div>

    <div style="display:flex;gap:12px;">
      <button type="submit" class="btn btn-primary">Save Material</button>
      <a href="{{ route('admin.materials.index') }}" class="btn btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection
