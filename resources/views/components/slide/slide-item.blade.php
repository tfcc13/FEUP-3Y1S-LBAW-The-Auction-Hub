@props(['title', 'currentBid', 'imageUrl', 'buttonAction'])

<div class="flex-shrink-0 w-[400px]">
    <div class="flex flex-col space-y-2 items-start bg-white rounded-lg shadow-md p-4">
        <img src="{{ $imageUrl }}" alt="{{ $title }}" class="w-full h-[200px] object-cover rounded-lg select-none" draggable="false">
        <h5 class="text-gray-800 font-medium">{{ $title }}</h5>
        <div class="h-6"></div>
        <div class="flex justify-between items-baseline w-full">
            <span class="text-gray-600 text-3xl font-semibold">${{ number_format($currentBid) }}</span>
            <button
                class="text-white px-6 py-2 rounded border-none bg-[#135d3b] hover:bg-[#135d3b]/75 transition-colors flex items-center active:scale-95">
                Bid Now
            </button>
        </div>
    </div>
</div>
