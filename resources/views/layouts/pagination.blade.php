{{-- resources/views/layouts/pagination.blade.php --}}
@if ($paginator->hasPages())
    <nav>
        <ul class="pagination mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link bg-dark border-dark">&laquo; Prev</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link bg-dark border-dark text-white" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Prev</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $elements = $paginator->elements();
            @endphp

            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link bg-dark border-dark">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link bg-primary border-primary">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link bg-dark border-dark text-white" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link bg-dark border-dark text-white" href="{{ $paginator->nextPageUrl() }}" rel="next">Next &raquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link bg-dark border-dark">Next &raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
