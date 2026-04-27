@if ($paginator->hasPages())
<div class="pagination">
  @if ($paginator->onFirstPage())
    <span class="page-link" style="opacity:.4;cursor:default;">&laquo; Prev</span>
  @else
    <a href="{{ $paginator->previousPageUrl() }}" class="page-link">&laquo; Prev</a>
  @endif
  @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="page-link">Next &raquo;</a>
  @else
    <span class="page-link" style="opacity:.4;cursor:default;">Next &raquo;</span>
  @endif
</div>
@endif
