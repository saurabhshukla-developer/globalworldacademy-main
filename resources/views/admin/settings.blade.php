@extends('admin.layouts.admin')
@section('title', 'Site Settings')
@section('page-title', '⚙️ Site Settings')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span> Settings
</div>

<form method="POST" action="{{ route('admin.settings.update') }}">
  @csrf @method('POST')

  @foreach($settings as $group => $groupSettings)
  <div class="card" style="margin-bottom:24px;">
    <div class="card-header">
      <div class="card-title" style="text-transform:capitalize;">
        @if($group=='general') ⚙️ General
        @elseif($group=='hero') 🦸 Hero Section
        @elseif($group=='stats') 📊 Stats Bar
        @elseif($group=='social') 🔗 Social Links
        @else {{ ucfirst($group) }}
        @endif
      </div>
    </div>
    <div class="form-row">
      @foreach($groupSettings as $s)
      <div class="form-group">
        <label class="form-label" for="setting_{{ $s['key'] }}">{{ $s['label'] ?? $s['key'] }}</label>
        @if(str_contains($s['key'], 'url') || str_contains($s['key'], 'website'))
          <input type="url" id="setting_{{ $s['key'] }}" name="{{ $s['key'] }}"
                 class="form-control" value="{{ $s['value'] ?? '' }}"/>
        @elseif(in_array($s['key'], ['hero_sub']))
          <textarea id="setting_{{ $s['key'] }}" name="{{ $s['key'] }}"
                    class="form-control" rows="3">{{ $s['value'] ?? '' }}</textarea>
        @else
          <input type="text" id="setting_{{ $s['key'] }}" name="{{ $s['key'] }}"
                 class="form-control" value="{{ $s['value'] ?? '' }}"/>
        @endif
      </div>
      @endforeach
    </div>
  </div>
  @endforeach

  <div style="position:sticky;bottom:0;background:#fff;border-top:1px solid var(--border);padding:16px 0;display:flex;gap:12px;">
    <button type="submit" class="btn btn-primary">💾 Save All Settings</button>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Cancel</a>
  </div>
</form>
@endsection
