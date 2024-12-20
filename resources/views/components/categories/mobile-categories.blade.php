@props(['mappedCategories', 'iconMap'])

<x-popup.popup position="bottom-left" width="w-64">
  <x-slot:trigger>
    <x-categories.category-item id="mobile-categories" text="Categories" icon="menu" onClick="togglePopup(this)" />
  </x-slot:trigger>

  <x-slot:content>
    <div class="space-y-4" role="list">
      @foreach ($mappedCategories as $category)
      <a href="{{ route('category.show', ['id' => $category->id]) }}">
        <div class="flex items-center gap-3 p-2 hover:bg-gray-100 rounded-md cursor-pointer" role="listitem"
          tabindex="0">
          <span class="material-symbols-outlined" aria-hidden="true">{{ $iconMap[$category->name] }}</span>
          <span>{{ $category->name }}</span>
        </div>
      </a>
      @endforeach
    </div>
  </x-slot:content>
</x-popup.popup>
