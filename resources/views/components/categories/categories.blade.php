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

<nav aria-label="Product Categories" class="flex items-center justify-between w-full" role="list">
    <x-categories.category-item id="upcoming-category" text="Upcoming" icon="local_fire_department" :onClick="redirectToUpcoming()" />

    @foreach ($mappedCategories as $category)
        <x-categories.category-item :id="$category->name . '-category'" :text="$category->name" :icon="$iconMap[$category->name]" {{-- :onclick="$searchCategory($text)"  --}} />
    @endforeach

    @if ($hasUnmappedCategories)
        <x-popup.popup position="bottom" :offset="-27">
            <x-slot:trigger>
                <x-categories.category-item id="more-categories" text="More Categories" icon="more_horiz"
                    onClick="togglePopup(this)" />
            </x-slot>

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
            </x-slot>
            </x-popup>
    @endif
</nav>
