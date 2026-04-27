@extends('admin.layouts.admin')
@section('title','Add Course')
@section('page-title','+ Add Course')
@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.courses.index') }}">Courses</a> <span>/</span> Add
</div>
<div class="card" style="max-width:820px;">
  <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Course Name <span class="req">*</span></label>
        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}"
               value="{{ old('name') }}" placeholder="e.g. Varg 2 Science Mains Course" required/>
        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Exam Tag <span class="req">*</span></label>
        <input type="text" name="exam_tag" class="form-control" value="{{ old('exam_tag') }}" placeholder="MPTET Varg 2" required/>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Description <span class="req">*</span></label>
      <textarea name="description" rows="2" class="form-control" placeholder="Short description..." required>{{ old('description') }}</textarea>
    </div>

    {{-- IMAGE UPLOAD (primary) --}}
    <div class="form-group">
      <label class="form-label">Course Image <span style="font-size:11px;color:var(--muted);">(recommended: 800×500px, max 2MB)</span></label>
      <div id="dropZone" style="border:2px dashed var(--border);border-radius:12px;padding:32px;text-align:center;cursor:pointer;transition:border-color .2s;background:var(--paper);"
           onclick="document.getElementById('imageInput').click()">
        <div id="dropPreview" style="display:none;">
          <img id="previewImg" style="max-height:160px;border-radius:8px;max-width:100%;" alt="Preview"/>
          <p style="margin-top:8px;font-size:12px;color:var(--muted);">Click to change image</p>
        </div>
        <div id="dropPlaceholder">
          <div style="font-size:36px;margin-bottom:8px;">🖼️</div>
          <div style="font-size:14px;font-weight:600;color:var(--navy);">Click to upload or drag & drop</div>
          <div style="font-size:12px;color:var(--muted);margin-top:4px;">PNG, JPG, WebP — max 2MB</div>
        </div>
      </div>
      <input type="file" id="imageInput" name="image" accept="image/*" style="display:none;"
             onchange="previewImage(this)"/>
      @error('image')<span class="invalid-feedback" style="display:block;margin-top:4px;">{{ $message }}</span>@enderror
    </div>

    {{-- Fallback thumbnail (used if no image uploaded) --}}
    <div class="card" style="background:var(--paper);padding:16px;margin-bottom:20px;">
      <div style="font-size:12px;font-weight:700;color:var(--muted);margin-bottom:12px;text-transform:uppercase;letter-spacing:.5px;">
        Fallback Thumbnail (used when no image is uploaded)
      </div>
      <div class="form-row-3">
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label">Gradient Class</label>
          <select name="thumb_class" class="form-control">
            @foreach(['ct1'=>'Blue','ct2'=>'Navy','ct3'=>'Green','ct4'=>'Red','ct5'=>'Purple','ct6'=>'Gold'] as $c=>$l)
            <option value="{{ $c }}" {{ old('thumb_class',$c=='ct1'?'ct1':'')== $c ? 'selected':'' }}>{{ $c }} – {{ $l }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label">Icon (emoji)</label>
          <input type="text" name="thumb_icon" class="form-control" value="{{ old('thumb_icon','📚') }}"/>
        </div>
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label">Sort Order</label>
          <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',0) }}" min="0"/>
        </div>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Badge Text</label>
        <input type="text" name="badge" class="form-control" value="{{ old('badge') }}" placeholder="🔥 Bestseller"/>
      </div>
      <div class="form-group">
        <label class="form-label">Badge Style</label>
        <select name="badge_style" class="form-control">
          <option value="badge-new">badge-new (blue)</option>
          <option value="badge-hot">badge-hot (gold)</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Features <span class="req">*</span></label>
      <textarea name="features" rows="4" class="form-control"
                placeholder="One feature per line:&#10;Complete Video Classes&#10;PDF Notes Included" required>{{ old('features') }}</textarea>
      <div class="form-hint">One feature per line.</div>
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
      <input type="url" name="buy_url" class="form-control"
             value="{{ old('buy_url','https://classplusapp.com/w/global-world-academy-xygeb') }}" required/>
    </div>

    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active',true) ? 'checked':'' }}/>
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

@push('scripts')
<script>
function previewImage(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('previewImg').src = e.target.result;
      document.getElementById('dropPreview').style.display = 'block';
      document.getElementById('dropPlaceholder').style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
// Drag and drop
var dz = document.getElementById('dropZone');
['dragenter','dragover'].forEach(function(ev) {
  dz.addEventListener(ev, function(e) { e.preventDefault(); dz.style.borderColor = 'var(--blue)'; });
});
['dragleave','drop'].forEach(function(ev) {
  dz.addEventListener(ev, function(e) { e.preventDefault(); dz.style.borderColor = 'var(--border)'; });
});
dz.addEventListener('drop', function(e) {
  var files = e.dataTransfer.files;
  if (files.length) {
    document.getElementById('imageInput').files = files;
    previewImage(document.getElementById('imageInput'));
  }
});
</script>
@endpush
