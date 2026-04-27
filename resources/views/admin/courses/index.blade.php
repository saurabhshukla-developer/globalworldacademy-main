@extends('admin.layouts.admin')
@section('title', 'Courses')
@section('page-title', '📚 Courses')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span> Courses
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">{{ $courses->total() }} Courses</div>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">+ Add Course</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>#</th><th>Name</th><th>Tag</th><th>Price</th><th>Order</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse($courses as $c)
        <tr>
          <td style="color:var(--muted);">{{ $c->id }}</td>
          <td>
            <strong>{{ $c->name }}</strong>
            @if($c->badge)
              <span class="badge" style="background:var(--gold-lt,#fef7e0);color:#7a5500;margin-left:6px;">{{ $c->badge }}</span>
            @endif
          </td>
          <td><span class="badge badge-topic">{{ $c->exam_tag }}</span></td>
          <td>
            ₹{{ number_format($c->price) }}
            @if($c->old_price)
              <span style="text-decoration:line-through;color:var(--muted);font-size:11px;margin-left:4px;">₹{{ number_format($c->old_price) }}</span>
            @endif
          </td>
          <td>{{ $c->sort_order }}</td>
          <td>
            <form method="POST" action="{{ route('admin.courses.toggle', $c) }}" style="display:inline;">
              @csrf @method('PATCH')
              <button type="submit" class="badge {{ $c->is_active ? 'badge-active' : 'badge-inactive' }}"
                      style="border:none;cursor:pointer;font-family:'Sora',sans-serif;">
                {{ $c->is_active ? '✓ Active' : '✗ Inactive' }}
              </button>
            </form>
          </td>
          <td>
            <div class="action-btns">
              <a href="{{ route('admin.courses.edit', $c) }}" class="btn btn-outline btn-icon btn-sm">✏️</a>
              <form method="POST" action="{{ route('admin.courses.destroy', $c) }}"
                    onsubmit="return confirm('Delete this course?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-icon btn-sm">🗑</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:32px;color:var(--muted);">
          No courses yet. <a href="{{ route('admin.courses.create') }}" style="color:var(--blue);">Add one →</a>
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $courses->links('vendor.pagination.simple') }}</div>
</div>
@endsection
