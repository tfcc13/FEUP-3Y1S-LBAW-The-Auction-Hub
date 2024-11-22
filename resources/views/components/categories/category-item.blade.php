@props(['text', 'icon', 'onClick' => null])

<div class="flex flex-col items-center transition-transform duration-300">
    <button
        @if($onClick) onclick="{{ $onClick }}" @endif
        class="flex w-16 h-16 justify-center items-center p-3 rounded-full border-none bg-transparent hover:bg-[#135d3b]/5 
        active:scale-90 active:bg-[#135d3b]/5 focus:bg-[#135d3b] group">
        <span class="material-symbols-outlined text-black aspect-square group-focus:text-white">
            {{ $icon }}
        </span>
    </button>
    <p class="text-gray-800 text-2xl text-center">{{ $text }}</p>
</div>

<style>
    .material-symbols-outlined {
        font-size: 28px;
    }
</style>