@if ($paginator->hasPages())
    <ul class="pagination">
        @php
            $totalPages = $paginator->lastPage();
            $currentPage = $paginator->currentPage();
        @endphp

        {{-- Previous Page Link --}}
        @if ($currentPage > 1)
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Show first 3 pages only for pages 1, 2 OR last 3 pages --}}
        @if ($currentPage <= 2 || $currentPage >= $totalPages - 2)
            @foreach(range(1, 3) as $page)
                <li class="page-item {{ $page == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                </li>
            @endforeach
            <li class="page-item disabled"><span class="page-link">...</span></li>
        @endif

        {{-- Show middle pages only if current page is > 2 and not in last 3 pages --}}
        @if ($currentPage > 2 && $currentPage < $totalPages - 2)
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($currentPage - 1) }}">{{ $currentPage - 1 }}</a></li>
            <li class="page-item active"><span class="page-link">{{ $currentPage }}</span></li>
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($currentPage + 1) }}">{{ $currentPage + 1 }}</a></li>
            <li class="page-item disabled"><span class="page-link">...</span></li>
        @endif

        {{-- Show last 3 pages always --}}
        @foreach(range($totalPages - 2, $totalPages) as $page)
            <li class="page-item {{ $page == $currentPage ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
            </li>
        @endforeach

        {{-- Next Page Link (hide if in last 3 pages) --}}
        @if ($currentPage < $totalPages - 2)
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @endif
    </ul>
@endif
