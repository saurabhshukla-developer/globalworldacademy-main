@extends('admin.layouts.admin')
@section('title','Post Categories')
@section('page-title','📰 Post Categories')
@section('content')

<style>
  .categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 16px;
    margin-top: 20px;
  }

  .category-card {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 16px;
    background: white;
    transition: all 0.3s ease;
    position: relative;
  }

  .category-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .category-card.featured {
    border-color: #ffc107;
    background: #fffbf0;
  }

  .category-card.featured::before {
    content: '★ Featured';
    position: absolute;
    top: 8px;
    right: 8px;
    background: #ffc107;
    color: #333;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
  }

  .category-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
  }

  .category-header img {
    width: 48px;
    height: 48px;
    border-radius: 4px;
    object-fit: cover;
  }

  .category-info h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
  }

  .category-info p {
    margin: 4px 0 0;
    font-size: 13px;
    color: var(--muted);
  }

  .category-description {
    font-size: 13px;
    color: #666;
    line-height: 1.5;
    margin-bottom: 12px;
    max-height: 60px;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .category-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 12px;
    border-top: 1px solid #eee;
  }

  .post-count {
    font-size: 12px;
    color: var(--muted);
  }

  .featured-toggle {
    display: inline-flex;
    align-items: center;
  }

  .featured-toggle input[type="checkbox"] {
    cursor: pointer;
    width: 18px;
    height: 18px;
  }

  .section-title {
    font-size: 18px;
    font-weight: 600;
    margin: 32px 0 16px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .featured-section {
    background: #fffbf0;
    border: 1px solid #ffc107;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 32px;
  }

  .featured-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .featured-item {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    padding: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: grab;
  }

  .featured-item:active {
    cursor: grabbing;
  }

  .featured-item-name {
    font-weight: 500;
    flex: 1;
  }

  .featured-item-handle {
    color: #999;
    margin-right: 12px;
    font-size: 18px;
  }

  .featured-item-remove {
    background: none;
    border: none;
    color: #d32f2f;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 4px;
    transition: background 0.2s;
  }

  .featured-item-remove:hover {
    background: #ffebee;
  }

  .no-featured {
    color: var(--muted);
    padding: 20px;
    text-align: center;
  }

  .alert {
    padding: 12px 16px;
    border-radius: 6px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .alert-success {
    background: #e8f5e9;
    border: 1px solid #4caf50;
    color: #2e7d32;
  }

  .alert-error {
    background: #ffebee;
    border: 1px solid #f44336;
    color: #c62828;
  }
</style>

<div class="breadcrumb">
  <a href="{{ route('admin.dashboard') }}">Dashboard</a>
  <span>/</span>
  Post Categories
</div>

@if ($rateLimited)
  <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:6px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;gap:12px;">
    <div style="display:flex;align-items:center;gap:12px;">
      <span style="font-size:18px;">⚠️</span>
      <div>
        <strong style="color:#856404;">API Rate Limited</strong>
        <div style="font-size:13px;color:#856404;">
          Showing cached data {{ $cachedAt ? 'from ' . $cachedAt->format('M d, g:i A') : '' }}
        </div>
      </div>
    </div>
    <a href="{{ route('admin.post-categories.refresh') }}" class="btn btn-outline btn-sm">↻ Refresh Now</a>
  </div>
@elseif ($fromCache)
  <div style="background:#e7f3ff;border:1px solid #0066cc;border-radius:6px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;gap:12px;">
    <div style="display:flex;align-items:center;gap:12px;">
      <span style="font-size:18px;">📦</span>
      <div style="font-size:13px;color:#003d99;">
        Showing cached data {{ $cachedAt ? 'from ' . $cachedAt->format('M d, g:i A') : '' }}
      </div>
    </div>
    <a href="{{ route('admin.post-categories.refresh') }}" class="btn btn-outline btn-sm">↻ Refresh Now</a>
  </div>
@elseif ($cachedAt)
  <div style="background:#e7f3ff;border:1px solid #0066cc;border-radius:6px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:12px;">
      <span style="font-size:18px;">🔄</span>
      <div style="font-size:13px;color:#003d99;">
        Last updated: {{ $cachedAt->format('M d, g:i A') }}
      </div>
    </div>
    <a href="{{ route('admin.post-categories.refresh') }}" class="btn btn-outline btn-sm">↻ Refresh Now</a>
  </div>
@endif

<!-- Featured Section -->
@if (count($featuredCategories) > 0)
  <div class="featured-section">
    <div class="section-title">
      <span>★</span>
      Featured Categories ({{ count($featuredCategories) }}/6)
    </div>

    <div class="featured-list" id="featured-list">
      @foreach ($featuredCategories as $featured)
        <div class="featured-item" data-category-slug="{{ $featured->slug }}" draggable="true">
          <span class="featured-item-handle">⋮⋮</span>
          <span class="featured-item-name">{{ $featured->slug }}</span>
          <form method="POST" action="{{ route('admin.post-categories.toggle-featured') }}" style="display:inline;">
            @csrf
            <input type="hidden" name="slug" value="{{ $featured->slug }}">
            <input type="hidden" name="is_featured" value="0">
            <button type="submit" class="featured-item-remove" title="Remove from featured">✕</button>
          </form>
        </div>
      @endforeach
    </div>
  </div>
@endif

<!-- All Categories -->
<div class="card">
  <div class="card-header">
    <div class="card-title">
      {{ count(array_filter($wpCategories, fn($c) => $c['count'] > 0)) }} Categories
      @if ($fromCache)
        <span style="font-size:12px;color:var(--muted);">(cached)</span>
      @endif
    </div>
  </div>

  @if (empty($wpCategories))
    <div style="padding: 40px; text-align: center; color: var(--muted);">
      @if ($error && !$fromCache)
        <p>⚠️ Could not fetch categories from WordPress API</p>
        <p style="font-size:12px;color:#999;">{{ $error }}</p>
        <a href="{{ route('admin.post-categories.refresh') }}" class="btn btn-outline btn-sm" style="margin-top:12px;">Try Again</a>
      @elseif (!$fromCache)
        <p>⚠️ Could not fetch categories from WordPress API.</p>
      @else
        <p>No cached categories available.</p>
      @endif
    </div>
  @else
    <div class="categories-grid">
      @foreach ($wpCategories as $category)
        @if ($category['count'] > 0)
          @php
            $isFeatured = in_array($category['slug'], $featuredSlugs);
          @endphp
          <div class="category-card {{ $isFeatured ? 'featured' : '' }}">
          <div class="category-header">
            @if (isset($category['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['thumbnail']['source_url']))
              <img src="{{ $category['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['thumbnail']['source_url'] }}"
                   alt="{{ $category['name'] }}">
            @else
              <div
                style="width:48px;height:48px;border-radius:4px;background:#e0e0e0;display:flex;align-items:center;justify-content:center;color:#999;">
                📁
              </div>
            @endif
            <div class="category-info">
              <h3>
                <a href="{{ $category['link'] }}" target="_blank" style="color: inherit; text-decoration: none;">
                  {{ $category['name'] }}
                </a>
              </h3>
              <p>{{ $category['count'] }} posts</p>
            </div>
          </div>

          @if ($category['description'])
            <div class="category-description">
              {!! strip_tags($category['description']) !!}
            </div>
          @endif

          <div class="category-footer">
            <span class="post-count">{{ $category['count'] }} post{{ $category['count'] !== 1 ? 's' : '' }}</span>

            <div style="display: flex; gap: 8px;">
              <a href="{{ $category['link'] }}" target="_blank" class="btn btn-outline btn-sm" title="View on WordPress">
                🔗
              </a>
              <form method="POST" action="{{ route('admin.post-categories.toggle-featured') }}" style="display:inline;">
                @csrf
                <input type="hidden" name="slug" value="{{ $category['slug'] }}">
                <input type="hidden" name="is_featured" value="{{ $isFeatured ? '0' : '1' }}">
                <button type="submit"
                        class="btn {{ $isFeatured ? 'btn-warning' : 'btn-outline' }} btn-sm">
                  {{ $isFeatured ? '★ Featured' : '☆ Mark Featured' }}
                </button>
              </form>
            </div>
          </div>
          </div>
        @endif
      @endforeach
    </div>
  @endif
</div>

@push('styles')
  <style>
    .btn-warning {
      background: #ffc107;
      color: #333;
      border: 1px solid #ffc107;
    }

    .btn-warning:hover {
      background: #ffb300;
      border-color: #ffb300;
    }

    .featured-item.dragging {
      opacity: 0.5;
    }

    .featured-item.drag-over {
      border-color: #0066cc;
      background: #eef7ff;
    }
  </style>
@endpush

@push('scripts')
  <script>
    (function() {
      const list = document.getElementById('featured-list');
      if (!list) return;

      let draggedItem = null;

      function updateOrder() {
        const items = Array.from(list.querySelectorAll('.featured-item'));
        const slugs = items.map(item => item.dataset.categorySlug).filter(Boolean);
        const token = '{{ csrf_token() }}';
        const url = '{{ route('admin.post-categories.reorder') }}';
        const formData = new FormData();

        slugs.forEach(slug => formData.append('order[]', slug));
        formData.append('_token', token);

        fetch(url, {
          method: 'POST',
          body: formData,
          credentials: 'same-origin',
        }).then(response => {
          if (!response.ok) {
            console.error('Reorder failed', response.statusText);
          }
        }).catch(err => console.error('Reorder error', err));
      }

      function handleDragStart(e) {
        draggedItem = e.currentTarget;
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', draggedItem.dataset.categorySlug);
        draggedItem.classList.add('dragging');
      }

      function handleDragEnd() {
        if (draggedItem) {
          draggedItem.classList.remove('dragging');
          draggedItem = null;
        }
      }

      function handleDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        const target = e.currentTarget;
        if (target && target !== draggedItem) {
          target.classList.add('drag-over');
        }
      }

      function handleDragLeave(e) {
        e.currentTarget.classList.remove('drag-over');
      }

      function handleDrop(e) {
        e.preventDefault();
        const target = e.currentTarget;
        target.classList.remove('drag-over');

        if (!draggedItem || target === draggedItem) {
          return;
        }

        const items = Array.from(list.querySelectorAll('.featured-item'));
        const draggedIndex = items.indexOf(draggedItem);
        const targetIndex = items.indexOf(target);

        if (draggedIndex < targetIndex) {
          list.insertBefore(draggedItem, target.nextSibling);
        } else {
          list.insertBefore(draggedItem, target);
        }

        updateOrder();
      }

      list.querySelectorAll('.featured-item').forEach(item => {
        item.addEventListener('dragstart', handleDragStart);
        item.addEventListener('dragend', handleDragEnd);
        item.addEventListener('dragover', handleDragOver);
        item.addEventListener('dragenter', handleDragOver);
        item.addEventListener('dragleave', handleDragLeave);
        item.addEventListener('drop', handleDrop);
      });
    })();
  </script>
@endpush
@endsection
