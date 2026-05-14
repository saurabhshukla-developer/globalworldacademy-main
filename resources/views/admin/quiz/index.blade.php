@extends('admin.layouts.admin')
@section('title', 'Quiz Questions')
@section('page-title', '🧠 Quiz Questions')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  <span>/</span> Quiz Questions
</div>

@if(session('import_errors'))
<div class="card" style="border-color:#f5c6cb;background:#fdf3f4;margin-bottom:16px;">
  <div class="card-header" style="border-bottom-color:#f5c6cb;">
    <strong style="color:#842029;">Import validation failed</strong>
    <span style="font-size:13px;color:var(--muted);margin-left:8px;">Fix the spreadsheet and try again. No rows were saved.</span>
  </div>
  <div style="padding:14px 18px;max-height:220px;overflow-y:auto;font-size:13px;line-height:1.55;color:#842029;">
    <ul style="margin:0;padding-left:18px;">
      @foreach(session('import_errors') as $err)
      <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
</div>
@endif

<div class="card">
  <div class="card-header">
    <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
      <form method="GET" style="display:flex;gap:10px;align-items:center;">
        <select name="topic_id" class="form-control" style="width:auto;padding:8px 12px;" onchange="this.form.submit()">
          <option value="">All Topics</option>
          @foreach($topics as $topic)
          <option value="{{ $topic->id }}" {{ (string) request('topic_id') === (string) $topic->id ? 'selected' : '' }}>
            {{ $topic->icon }} {{ $topic->name }}
          </option>
          @endforeach
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
          <td>
            @if($q->quizTopic)
              <div style="font-size:11px;color:var(--muted);">{{ $q->quizTopic->subject->name ?? '' }}</div>
              <span class="badge badge-topic">{{ $q->quizTopic->icon }} {{ $q->quizTopic->name }}</span>
            @else
              <span class="badge badge-inactive">{{ $q->topic }}</span>
            @endif
          </td>
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

<div class="card" style="margin-top:20px;">
  <div class="card-header">
    <strong>Import from Excel</strong>
    <span style="font-size:13px;color:var(--muted);margin-left:8px;">.xlsx only · max 5 MB · up to {{ \App\Services\QuizQuestionsExcelImportService::MAX_DATA_ROWS }} rows</span>
  </div>
  <div style="padding:18px;display:flex;flex-wrap:wrap;gap:16px;align-items:flex-end;">
    <a href="{{ route('admin.quiz.import-template') }}" class="btn btn-outline">⬇ Download demo template</a>
    <form method="POST" action="{{ route('admin.quiz.import') }}" enctype="multipart/form-data" style="display:flex;flex-wrap:wrap;gap:12px;align-items:center;">
      @csrf
      <input type="file" name="file" accept=".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required
             class="form-control {{ $errors->has('file') ? 'is-invalid' : '' }}" style="max-width:280px;padding:8px;"/>
      <button type="submit" class="btn btn-primary">Upload &amp; import</button>
    </form>
    @error('file')
    <p style="width:100%;margin:0;font-size:13px;color:#842029;">{{ $message }}</p>
    @enderror
  </div>
  <p style="margin:0 18px 18px;font-size:13px;color:var(--muted);line-height:1.6;">
    The workbook must include a sheet named <strong>Questions</strong> with columns <code>subject_id</code> and <code>topic_id</code> (copy IDs from <strong>Subjects reference</strong> and <strong>Topics reference</strong>; <code>topic_id</code> must belong to that <code>subject_id</code>). All rows are validated before anything is saved.
  </p>
</div>
@endsection
