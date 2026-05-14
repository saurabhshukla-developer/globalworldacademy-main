@extends('admin.layouts.admin')
@section('title','Quiz Subjects')
@section('page-title','🗂️ Quiz Subjects')
@section('content')
<div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span> Subjects</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">{{ $subjects->total() }} Subjects</div>
    <a href="{{ route('admin.quiz-subjects.create') }}" class="btn btn-primary">+ Add Subject</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>#</th><th>Icon</th><th>Name</th><th>Hindi</th><th>Topics</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($subjects as $subject)
        <tr>
          <td style="color:var(--muted);">{{ $subject->id }}</td>
          <td style="font-size:22px;">{{ $subject->icon }}</td>
          <td>
            <strong>{{ $subject->name }}</strong>
            <div style="width:16px;height:4px;border-radius:2px;background:{{ $subject->color }};margin-top:4px;"></div>
          </td>
          <td style="font-family:'Noto Sans Devanagari',sans-serif;">{{ $subject->name_hi ?? '—' }}</td>
          <td>
            <a href="{{ route('admin.quiz-topics.index', ['subject_id'=>$subject->id]) }}"
               class="badge badge-topic">{{ $subject->topics_count ?? 0 }} Topics</a>
          </td>
          <td>{{ $subject->sort_order }}</td>
          <td>
            <form method="POST" action="{{ route('admin.quiz-subjects.toggle', $subject) }}" style="display:inline;">
              @csrf @method('PATCH')
              <button type="submit" class="badge {{ $subject->is_active ? 'badge-active':'badge-inactive' }}"
                      style="border:none;cursor:pointer;font-family:'Sora',sans-serif;">
                {{ $subject->is_active ? '✓ Active':'✗ Inactive' }}
              </button>
            </form>
          </td>
          <td>
            <div class="action-btns">
              <a href="{{ route('admin.quiz-topics.index', ['subject_id'=>$subject->id]) }}" class="btn btn-outline btn-sm" title="View Topics">Topics</a>
              <a href="{{ route('admin.quiz-subjects.edit', $subject) }}" class="btn btn-outline btn-icon btn-sm">✏️</a>
              <form method="POST" action="{{ route('admin.quiz-subjects.destroy', $subject) }}" onsubmit="return confirm('Delete subject and ALL its topics & questions?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-icon btn-sm">🗑</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;padding:32px;color:var(--muted);">
          No subjects yet. <a href="{{ route('admin.quiz-subjects.create') }}" style="color:var(--blue);">Add one →</a>
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $subjects->links('vendor.pagination.simple') }}</div>
</div>
@endsection
