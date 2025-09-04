@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @php
            $totalPages = $paginator->lastPage();
            $currentPage = $paginator->currentPage();
            $startPages = [1, 2, 3]; // Always show first 3 pages
            $endPages = [$totalPages - 2, $totalPages - 1, $totalPages]; // Always show last 3 pages
        @endphp

        @foreach(range(1, $totalPages) as $page)
            @if(in_array($page, $startPages) || in_array($page, $endPages) || abs($currentPage - $page) <= 1)
                <li class="page-item {{ ($page == $currentPage) ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                </li>
            @elseif($page == 3 || $page == $totalPages - 3)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
@endif
