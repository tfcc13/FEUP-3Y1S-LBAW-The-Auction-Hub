@props(['categories'])

@php
    $iconMap = [
        'Watches' => 'watch',
        'Vehicles' => 'directions_car',
        'Jewelry' => 'diamond',
        'Collectibles' => 'transition_dissolve',
        'Sports Memorabilia' => 'sports_basketball',
        'Art' => 'palette',
        'Antiques' => 'imagesmode',
        'Coins & Paper Money' => 'paid',
        'Electronics' => 'devices',
    ];

    $mappedCategories = $categories->filter(function ($category) use ($iconMap) {
        return isset($iconMap[$category->name]);
    });

    $unmappedCategories = $categories->filter(function ($category) use ($iconMap) {
        return !isset($iconMap[$category->name]);
    });

    $hasUnmappedCategories = $unmappedCategories->isNotEmpty();

    function redirectToUpcoming()
    {
        return "window.location.href = '" . route('search.upcoming') . "'";
    }
@endphp

<nav aria-label="Product Categories"
    class="grid grid-flow-col grid-rows-1 sm:grid-rows-2 lg:grid-rows-1 items-center justify-between w-full"
    role="list">
    <x-categories.category-item id="upcoming-category" text="Upcoming" icon="local_fire_department" :onClick="redirectToUpcoming()" />

    <div class="hidden sm:contents">
        @foreach ($mappedCategories as $category)
            <x-categories.category-item :id="$category->id" :text="$category->name" :icon="$iconMap[$category->name]" :onClick="'window.location.href=\'' . route('category.show', $category->id) . '\''" />
        @endforeach
    </div>

    {{-- Mobile View Component --}}
    <div class="sm:hidden">
        <x-categories.mobile-categories :mappedCategories="$mappedCategories" :iconMap="$iconMap" />
    </div>

    @if ($hasUnmappedCategories)
        <x-popup.popup position="bottom" :offset="-27">
            <x-slot:trigger>
                <x-categories.category-item id="more-categories" text="More Categories" icon="more_horiz"
                    onClick="togglePopup(this)" />
            </x-slot:trigger>

            <x-slot:content>
                <div class="space-y-4" role="list">
                    @foreach ($unmappedCategories as $category)
                        <div class="flex items-center gap-3 p-2 hover:bg-gray-100 rounded-md cursor-pointer"
                            role="listitem" tabindex="0">
                            <span class="material-symbols-outlined" aria-hidden="true">category</span>
                            <span>{{ $category->name }}</span>
                        </div>
                    @endforeach
                </div>
            </x-slot:content>
        </x-popup.popup>
    @endif
</nav>
