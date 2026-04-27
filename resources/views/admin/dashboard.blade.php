@extends('admin.layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="stat-cards">
  <div class="stat-card">
    <div class="stat-icon si-blue">🧠</div>
    <div>
      <div class="stat-num">{{ $stats['questions'] }}</div>
      <div class="stat-lbl">Quiz Questions</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon si-green">📚</div>
    <div>
      <div class="stat-num">{{ $stats['courses'] }}</div>
      <div class="stat-lbl">Courses</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon si-gold">📥</div>
    <div>
      <div class="stat-num">{{ $stats['materials'] }}</div>
      <div class="stat-lbl">Study Materials</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon si-purple">⚙️</div>
    <div>
      <div class="stat-num">{{ $stats['settings'] }}</div>
      <div class="stat-lbl">Site Settings</div>
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

  {{-- Quick Actions --}}
  <div class="card">
    <div class="card-header">
      <div class="card-title">⚡ Quick Actions</div>
    </div>
    <div style="display:flex;flex-direction:column;gap:10px;">
      <a href="{{ route('admin.quiz.create') }}" class="btn btn-primary">+ Add Quiz Question</a>
      <a href="{{ route('admin.courses.create') }}" class="btn btn-success">+ Add Course</a>
      <a href="{{ route('admin.materials.create') }}" class="btn btn-outline">+ Add Study Material</a>
      <a href="{{ route('admin.settings') }}" class="btn btn-outline">⚙️ Manage Settings</a>
    </div>
  </div>

  {{-- Recent Questions --}}
  <div class="card">
    <div class="card-header">
      <div class="card-title">🧠 Recent Questions</div>
      <a href="{{ route('admin.quiz.index') }}" class="btn btn-ghost btn-sm">View All</a>
    </div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr><th>Topic</th><th>Question</th><th>Status</th></tr>
        </thead>
        <tbody>
          @forelse($recentQuestions as $q)
          <tr>
            <td><span class="badge badge-topic">{{ $q->topic }}</span></td>
            <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $q->question }}</td>
            <td>
              <span class="badge {{ $q->is_active ? 'badge-active' : 'badge-inactive' }}">
                {{ $q->is_active ? 'Active' : 'Inactive' }}
              </span>
            </td>
          </tr>
          @empty
          <tr><td colspan="3" style="text-align:center;color:var(--muted);padding:20px;">No questions yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<div class="card" style="margin-top:24px;">
  <div class="card-header">
    <div class="card-title">🔗 Website Links</div>
  </div>
  <div style="display:flex;gap:12px;flex-wrap:wrap;">
    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline">🌐 View Landing Page</a>
    <a href="{{ route('quiz') }}" target="_blank" class="btn btn-outline">🧩 View Quiz Page</a>
  </div>
</div>
@endsection
