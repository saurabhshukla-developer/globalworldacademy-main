@extends('admin.layouts.admin')
@section('title','Quiz Topics')
@section('page-title','🏷️ Quiz Topics')
@section('content')
<div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> <span>/</span> Topics</div>

<div class="card">
  <div class="card-header">
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
      <form method="GET" style="display:flex;gap:8px;align-items:center;">
        <select name="subject_id" class="form-control" style="width:auto;padding:8px 12px;" onchange="this.form.submit()">
          <option value="">All Subjects</option>
          @foreach($subjects as $subject)
          <option value="{{ $subject->id }}" {{ request('subject_id')==$subject->id ? 'selected':'' }}>{{ $subject->icon }} {{ $subject->name }}</option>
          @endforeach
        </select>
      </form>
      <span style="font-size:13px;color:var(--muted);">{{ $topics->total() }} topics</span>
    </div>
    <a href="{{ route('admin.quiz-topics.create') }}" class="btn btn-primary">+ Add Topic</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>#</th><th>Subject</th><th>Icon</th><th>Name</th><th>Hindi</th><th>Questions</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($topics as $topic)
        <tr>
          <td style="color:var(--muted);">{{ $topic->id }}</td>
          <td>
            @if($topic->subject)
              <span class="badge badge-topic" style="background:{{ $topic->subject->color }}20;color:{{ $topic->subject->color }};">
                {{ $topic->subject->icon }} {{ $topic->subject->name }}
              </span>
            @endif
          </td>
          <td style="font-size:20px;">{{ $topic->icon }}</td>
          <td><strong>{{ $topic->name }}</strong></td>
          <td style="font-family:'Noto Sans Devanagari',sans-serif;">{{ $topic->name_hi ?? '—' }}</td>
          <td>
            <a href="{{ route('admin.quiz.index', ['topic_id'=>$topic->id]) }}" class="badge badge-topic">
              {{ $topic->questions_count }} Q
            </a>
          </td>
          <td>{{ $topic->sort_order }}</td>
          <td>
            <form method="POST" action="{{ route('admin.quiz-topics.toggle', $topic) }}" style="display:inline;">
              @csrf @method('PATCH')
              <button type="submit" class="badge {{ $topic->is_active ? 'badge-active':'badge-inactive' }}"
                      style="border:none;cursor:pointer;font-family:'Sora',sans-serif;">
                {{ $topic->is_active ? '✓ Active':'✗ Inactive' }}
              </button>
            </form>
          </td>
          <td>
            <div class="action-btns">
              <a href="{{ route('admin.quiz-topics.edit', $topic) }}" class="btn btn-outline btn-icon btn-sm">✏️</a>
              <form method="POST" action="{{ route('admin.quiz-topics.destroy', $topic) }}" onsubmit="return confirm('Delete this topic?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-icon btn-sm">🗑</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center;padding:32px;color:var(--muted);">
          No topics yet. <a href="{{ route('admin.quiz-topics.create') }}" style="color:var(--blue);">Add one →</a>
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="pagination">{{ $topics->links('vendor.pagination.simple') }}</div>
</div>
@endsection
