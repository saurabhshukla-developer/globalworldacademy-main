@extends('admin.layouts.admin')
@section('title','Edit Course')
@section('page-title','✏️ Edit Course')
@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span>
  <a href="{{ route('admin.courses.index') }}">Courses</a> <span>/</span> Edit #{{ $course->id }}
</div>
<div class="card" style="max-width:820px;">
  <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Course Name <span class="req">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name',$course->name) }}" required/>
      </div>
      <div class="form-group">
        <label class="form-label">Exam Tag <span class="req">*</span></label>
        <input type="text" name="exam_tag" class="form-control" value="{{ old('exam_tag',$course->exam_tag) }}" required/>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Description <span class="req">*</span></label>
      <textarea name="description" rows="2" class="form-control" required>{{ old('description',$course->description) }}</textarea>
    </div>

    {{-- IMAGE UPLOAD --}}
    <div class="form-group">
      <label class="form-label">Course Image</label>
      @if($course->image_url)
        <div style="margin-bottom:12px;display:flex;align-items:flex-start;gap:16px;">
          <img src="{{ $course->image_url }}" alt="Current" style="height:100px;border-radius:10px;object-fit:cover;border:1px solid var(--border);"/>
          <div>
            <div style="font-size:12px;color:var(--muted);margin-bottom:8px;">Current image</div>
            <label class="form-check" style="cursor:pointer;">
              <input type="checkbox" name="remove_image" value="1" style="accent-color:var(--red);" onchange="document.getElementById('imgReplaceArea').style.opacity=this.checked?'.4':'1'"/>
              <span style="font-size:13px;color:var(--red);font-weight:600;">Remove image</span>
            </label>
          </div>
        </div>
      @endif
      <div id="imgReplaceArea">
        <div id="dropZone" style="border:2px dashed var(--border);border-radius:12px;padding:24px;text-align:center;cursor:pointer;transition:border-color .2s;background:var(--paper);"
             onclick="document.getElementById('imageInput').click()">
          <div id="dropPreview" style="display:none;">
            <img id="previewImg" style="max-height:120px;border-radius:8px;max-width:100%;" alt="Preview"/>
            <p style="margin-top:8px;font-size:12px;color:var(--muted);">Click to change</p>
          </div>
          <div id="dropPlaceholder">
            <div style="font-size:28px;margin-bottom:6px;">🖼️</div>
            <div style="font-size:13px;font-weight:600;color:var(--navy);">{{ $course->image_url ? 'Upload replacement image' : 'Click to upload or drag & drop' }}</div>
            <div style="font-size:11px;color:var(--muted);margin-top:3px;">PNG, JPG, WebP — max 2MB</div>
          </div>
        </div>
        <input type="file" id="imageInput" name="image" accept="image/*" style="display:none;" onchange="previewImage(this)"/>
        @error('image')<span class="invalid-feedback" style="display:block;margin-top:4px;">{{ $message }}</span>@enderror
      </div>
    </div>

    {{-- Fallback --}}
    <div class="card" style="background:var(--paper);padding:16px;margin-bottom:20px;">
      <div style="font-size:12px;font-weight:700;color:var(--muted);margin-bottom:12px;text-transform:uppercase;letter-spacing:.5px;">Fallback Thumbnail</div>
      <div class="form-row-3">
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label">Gradient Class</label>
          <select name="thumb_class" class="form-control">
            @foreach(['ct1'=>'Blue','ct2'=>'Navy','ct3'=>'Green','ct4'=>'Red','ct5'=>'Purple','ct6'=>'Gold'] as $c=>$l)
            <option value="{{ $c }}" {{ old('thumb_class',$course->thumb_class)==$c ? 'selected':'' }}>{{ $c }} – {{ $l }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label">Icon (emoji)</label>
          <input type="text" name="thumb_icon" class="form-control" value="{{ old('thumb_icon',$course->thumb_icon) }}"/>
        </div>
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label">Sort Order</label>
          <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$course->sort_order) }}" min="0"/>
        </div>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Badge Text</label>
        <input type="text" name="badge" class="form-control" value="{{ old('badge',$course->badge) }}"/>
      </div>
      <div class="form-group">
        <label class="form-label">Badge Style</label>
        <select name="badge_style" class="form-control">
          <option value="badge-new" {{ old('badge_style',$course->badge_style)=='badge-new' ? 'selected':'' }}>badge-new (blue)</option>
          <option value="badge-hot" {{ old('badge_style',$course->badge_style)=='badge-hot' ? 'selected':'' }}>badge-hot (gold)</option>
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
        <input type="number" name="price" class="form-control" value="{{ old('price',$course->price) }}" step="0.01" min="0" required/>
      </div>
      <div class="form-group">
        <label class="form-label">Old Price (₹)</label>
        <input type="number" name="old_price" class="form-control" value="{{ old('old_price',$course->old_price) }}" step="0.01" min="0"/>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Buy URL <span class="req">*</span></label>
      <input type="url" name="buy_url" class="form-control" value="{{ old('buy_url',$course->buy_url) }}" required/>
    </div>

    <div class="form-group">
      <div class="form-check">
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ $course->is_active ? 'checked':'' }}/>
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
var dz = document.getElementById('dropZone');
['dragenter','dragover'].forEach(function(ev) { dz.addEventListener(ev, function(e){ e.preventDefault(); dz.style.borderColor='var(--blue)'; }); });
['dragleave','drop'].forEach(function(ev) { dz.addEventListener(ev, function(e){ e.preventDefault(); dz.style.borderColor='var(--border)'; }); });
dz.addEventListener('drop', function(e) {
  var files = e.dataTransfer.files;
  if (files.length) { document.getElementById('imageInput').files = files; previewImage(document.getElementById('imageInput')); }
});
</script>
@endpush
