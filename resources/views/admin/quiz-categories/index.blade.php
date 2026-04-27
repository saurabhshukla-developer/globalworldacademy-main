@extends('admin.layouts.admin')
@section('title','Quiz Categories')
@section('page-title','🗂️ Quiz Categories')
@section('content')
<div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span> Categories</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">{{ $categories->total() }} Categories</div>
    <a href="{{ route('admin.quiz-categories.create') }}" class="btn btn-primary">+ Add Category</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>#</th><th>Icon</th><th>Name</th><th>Hindi</th><th>Topics</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($categories as $cat)
        <tr>
          <td style="color:var(--muted);">{{ $cat->id }}</td>
          <td style="font-size:22px;">{{ $cat->icon }}</td>
          <td>
            <strong>{{ $cat->name }}</strong>
            <div style="width:16px;height:4px;border-radius:2px;background:{{ $cat->color }};margin-top:4px;"></div>
          </td>
          <td style="font-family:'Noto Sans Devanagari',sans-serif;">{{ $cat->name_hi ?? '—' }}</td>
          <td>
            <a href="{{ route('admin.quiz-topics.index', ['category_id'=>$cat->id]) }}"
               class="badge badge-topic">{{ $cat->topics_count ?? 0 }} Topics</a>
          </td>
          <td>{{ $cat->sort_order }}</td>
          <td>
            <form method="POST" action="{{ route('admin.quiz-categories.toggle', $cat) }}" style="display:inline;">
              @csrf @method('PATCH')
              <button type="submit" class="badge {{ $cat->is_active ? 'badge-active':'badge-inactive' }}"
                      style="border:none;cursor:pointer;font-family:'Sora',sans-serif;">
                {{ $cat->is_active ? '✓ Active':'✗ Inactive' }}
              </button>
            </form>
          </td>
          <td>
            <div class="action-btns">
              <a href="{{ route('admin.quiz-topics.index', ['category_id'=>$cat->id]) }}" class="btn btn-outline btn-sm" title="View Topics">Topics</a>
              <a href="{{ route('admin.quiz-categories.edit', $cat) }}" class="btn btn-outline btn-icon btn-sm">✏️</a>
              <form method="POST" action="{{ route('admin.quiz-categories.destroy', $cat) }}" onsubmit="return confirm('Delete category and ALL its topics & questions?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-icon btn-sm">🗑</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;padding:32px;color:var(--muted);">
          No categories yet. <a href="{{ route('admin.quiz-categories.create') }}" style="color:var(--blue);">Add one →</a>
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $categories->links('vendor.pagination.simple') }}</div>
</div>
@endsection
