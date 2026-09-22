@php $activeCat = request()->get('category'); @endphp
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
        @endforeach
    </ul>
</div>
