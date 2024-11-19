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

    $mappedCategories = $categories->filter(function($category) use ($iconMap) {
        return isset($iconMap[$category->name]);
    });

    $unmappedCategories = $categories->filter(function($category) use ($iconMap) {
        return !isset($iconMap[$category->name]);
    });
    
    $hasUnmappedCategories = $unmappedCategories->isNotEmpty();
@endphp

<div class="flex items-center justify-between w-full px-52">
    @foreach ($mappedCategories as $category)
        <x-categories.category-item
            :text="$category->name"
            :icon="$iconMap[$category->name]"
            {{-- :onclick="$searchCategory($text)"  --}}
        />
    @endforeach

    @if ($hasUnmappedCategories)
        <x-popup.popup position="bottom" :offset="-27">
            <x-slot:trigger>
                <x-categories.category-item
                    text="More"
                    icon="more_horiz"
                    onClick="togglePopup(this)" />
            </x-slot>
            
            <x-slot:content>
                <div class="space-y-4">
                    @foreach ($unmappedCategories as $category)
                        <div class="flex items-center gap-3 p-2 hover:bg-gray-100 rounded-md cursor-pointer">
                            <span class="material-symbols-outlined">category</span>
                            <span>{{ $category->name }}</span>
                        </div>
                    @endforeach
                </div>
            </x-slot>
        </x-popup>
    @endif
</div>