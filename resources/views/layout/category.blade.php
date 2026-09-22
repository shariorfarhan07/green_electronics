@php
    $activeCat = request()->get('category');
    // Keep a section open when the active filter is the section itself or any of its children.
    $activeParent = null;
    foreach ($navCategories ?? [] as $c) {
        if ($c->slug === $activeCat || $c->children->contains('slug', $activeCat)) {
            $activeParent = $c->slug;
            break;
        }
    }
@endphp
<div class="wb-sidebar">
    <div class="wb-sidebar__title">Browse Categories</div>
    <ul class="wb-sidebar__list">
        <li class="wb-sidebar__item {{ !$activeCat ? 'is-active' : '' }}">
            <a href="{{ route('shop') }}"><span>All Products</span> <x-icon name="chevron-right" :size="15" /></a>
        </li>
        @foreach($navCategories ?? [] as $cat)
            <li class="wb-sidebar__item {{ $activeCat === $cat->slug ? 'is-active' : '' }}">
                <a href="{{ route('shop', ['category' => $cat->slug]) }}">
                    <span><x-icon :name="$cat->icon" :size="15" /> {{ $cat->name }}</span>
                    <x-icon name="chevron-right" :size="15" />
                </a>
            </li>
            @if($activeParent === $cat->slug && $cat->children->count())
                <li class="wb-sidebar__children">
                    <ul>
                        @foreach($cat->children as $child)
                            <li><a href="{{ route('shop', ['category' => $child->slug]) }}" class="{{ $activeCat === $child->slug ? 'is-active' : '' }}">{{ $child->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
    </ul>
</div>
