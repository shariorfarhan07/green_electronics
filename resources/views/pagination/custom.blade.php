{{--
    Laravel's built-in pagination views ("tailwind"/"bootstrap-4") assume that
    framework's CSS is loaded on the page. This app ships neither, so those views'
    bare `<svg class="w-5 h-5">` arrows rendered at their unconstrained intrinsic
    size (hundreds of pixels) and every other utility class was a no-op — this
    view replaces them app-wide (see Paginator::defaultView in AppServiceProvider)
    with markup styled by the app's own wb-pagination classes.
--}}
@if ($paginator->hasPages())
    <nav class="wb-pagination" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        <div class="wb-pagination__meta">
            {{ __('Showing') }}
            <strong>{{ $paginator->firstItem() ?? 0 }}</strong>
            {{ __('to') }}
            <strong>{{ $paginator->lastItem() ?? 0 }}</strong>
            {{ __('of') }}
            <strong>{{ $paginator->total() }}</strong>
            {{ __('results') }}
        </div>

        <ul class="wb-pagination__list">
            @if ($paginator->onFirstPage())
                <li class="wb-pagination__item wb-pagination__item--disabled" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <x-icon name="chevron-left" :size="15" />
                </li>
            @else
                <li>
                    <a class="wb-pagination__item" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}">
                        <x-icon name="chevron-left" :size="15" />
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="wb-pagination__item wb-pagination__item--ellipsis" aria-disabled="true">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="wb-pagination__item wb-pagination__item--current" aria-current="page">{{ $page }}</li>
                        @else
                            <li>
                                <a class="wb-pagination__item" href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a class="wb-pagination__item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}">
                        <x-icon name="chevron-right" :size="15" />
                    </a>
                </li>
            @else
                <li class="wb-pagination__item wb-pagination__item--disabled" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <x-icon name="chevron-right" :size="15" />
                </li>
            @endif
        </ul>
    </nav>
@endif
