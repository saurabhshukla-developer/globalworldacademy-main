@extends('admin.layouts.admin')
@section('title', 'Study Materials')
@section('page-title', '📥 Study Materials')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span> Study Materials
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">{{ $materials->total() }} Materials</div>
    <a href="{{ route('admin.materials.create') }}" class="btn btn-primary">+ Add Material</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>#</th><th>Icon</th><th>Title</th><th>Topic</th><th>Tags</th><th>Order</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse($materials as $m)
        <tr>
          <td style="color:var(--muted);">{{ $m->id }}</td>
          <td style="font-size:20px;">{{ $m->icon }}</td>
          <td><strong>{{ $m->title }}</strong></td>
          <td style="font-size:13px;color:var(--muted);max-width:200px;">
            @if($m->quizTopic)
              {{ $m->quizTopic->subject->name ?? '—' }} · {{ $m->quizTopic->name }}
            @else
              —
            @endif
          </td>
          <td>
            @foreach($m->tags ?? [] as $tag)
              <span class="badge" style="background:var(--blue-lt);color:var(--blue);margin:2px;">{{ $tag }}</span>
            @endforeach
          </td>
          <td>{{ $m->sort_order }}</td>
          <td>
            <form method="POST" action="{{ route('admin.materials.toggle', $m) }}" style="display:inline;">
              @csrf @method('PATCH')
              <button type="submit" class="badge {{ $m->is_active ? 'badge-active' : 'badge-inactive' }}"
                      style="border:none;cursor:pointer;font-family:'Sora',sans-serif;">
                {{ $m->is_active ? '✓ Active' : '✗ Inactive' }}
              </button>
            </form>
          </td>
          <td>
            <div class="action-btns">
              <a href="{{ route('admin.materials.edit', $m) }}" class="btn btn-outline btn-icon btn-sm">✏️</a>
              <form method="POST" action="{{ route('admin.materials.destroy', $m) }}"
                    onsubmit="return confirm('Delete this material?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-icon btn-sm">🗑</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;padding:32px;color:var(--muted);">
          No materials yet. <a href="{{ route('admin.materials.create') }}" style="color:var(--blue);">Add one →</a>
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $materials->links('vendor.pagination.simple') }}</div>
</div>
@endsection
