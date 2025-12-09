{{-- resources/views/layouts/pagination.blade.php --}}
@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link rounded-start">
                        <i class="fas fa-chevron-left me-1"></i> Prev
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-start" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="fas fa-chevron-left me-1"></i> Prev
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $elements = $paginator->elements();
            @endphp

            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-end" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        Next <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link rounded-end">
                        Next <i class="fas fa-chevron-right ms-1"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
