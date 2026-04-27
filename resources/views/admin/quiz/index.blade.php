@extends('admin.layouts.admin')
@section('title', 'Quiz Questions')
@section('page-title', '🧠 Quiz Questions')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  <span>/</span> Quiz Questions
</div>

<div class="card">
  <div class="card-header">
    <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
      <form method="GET" style="display:flex;gap:10px;align-items:center;">
        <select name="topic" class="form-control" style="width:auto;padding:8px 12px;" onchange="this.form.submit()">
          <option value="">All Topics</option>
          <option value="science"   {{ request('topic')=='science'   ? 'selected' : '' }}>🔬 Science</option>
          <option value="child_dev" {{ request('topic')=='child_dev' ? 'selected' : '' }}>👶 Child Dev</option>
          <option value="gk"        {{ request('topic')=='gk'        ? 'selected' : '' }}>🌍 GK</option>
          <option value="mp"        {{ request('topic')=='mp'        ? 'selected' : '' }}>🗺️ MP GK</option>
        </select>
      </form>
      <span style="font-size:13px;color:var(--muted);">{{ $questions->total() }} questions</span>
    </div>
    <a href="{{ route('admin.quiz.create') }}" class="btn btn-primary">+ Add Question</a>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th><th>Topic</th><th>Question</th><th>Answer</th><th>Order</th><th>Status</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($questions as $q)
        <tr>
          <td style="color:var(--muted);">{{ $q->id }}</td>
          <td><span class="badge badge-topic">{{ $q->topic }}</span></td>
          <td style="max-width:280px;">{{ Str::limit($q->question, 70) }}</td>
          <td style="font-weight:700;color:var(--green);">{{ ['A','B','C','D'][$q->answer_index] }}</td>
          <td>{{ $q->sort_order }}</td>
          <td>
            <form method="POST" action="{{ route('admin.quiz.toggle', $q) }}" style="display:inline;">
              @csrf @method('PATCH')
              <button type="submit" class="badge {{ $q->is_active ? 'badge-active' : 'badge-inactive' }}"
                      style="border:none;cursor:pointer;font-family:'Sora',sans-serif;">
                {{ $q->is_active ? '✓ Active' : '✗ Inactive' }}
              </button>
            </form>
          </td>
          <td>
            <div class="action-btns">
              <a href="{{ route('admin.quiz.edit', $q) }}" class="btn btn-outline btn-icon btn-sm" title="Edit">✏️</a>
              <form method="POST" action="{{ route('admin.quiz.destroy', $q) }}"
                    onsubmit="return confirm('Delete this question?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-icon btn-sm" title="Delete">🗑</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:32px;color:var(--muted);">
          No questions yet. <a href="{{ route('admin.quiz.create') }}" style="color:var(--blue);">Add one →</a>
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pagination">
    {{ $questions->links('vendor.pagination.simple') }}
  </div>
</div>
@endsection
