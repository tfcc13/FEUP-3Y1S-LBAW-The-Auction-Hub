@props(['id', 'text', 'icon', 'onClick' => null])

<div id="{{ $id }}" class="flex flex-col items-center transition-transform duration-300" role="listitem">
  <button @if ($onClick) onclick="{{ $onClick }}" @endif
    class="flex justify-center items-center p-2 rounded-full border-none bg-transparent hover:bg-[#135d3b]/5 
        active:scale-90 active:bg-[#135d3b]/5 focus:bg-[#135d3b] group focus:outline-none"
    aria-label="{{ $text }}" title="{{ $text }}"
    id="{{ $id }}"
    data-category="{{$id}}">

    <span class="material-symbols-outlined text-black aspect-square group-focus:text-white" aria-hidden="true">
      {{ $icon }}
    </span>
  </button>
  <p class="text-gray-800 font-medium text-center" id="{{ Str::slug($text) }}-category">{{ $text }}</p>
</div>

<style>
  .material-symbols-outlined {
    font-size: 28px;
  }
</style>
