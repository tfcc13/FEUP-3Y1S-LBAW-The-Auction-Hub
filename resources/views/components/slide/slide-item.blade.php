@props(['title', 'currentBid', 'imageUrl', 'buttonAction'])

<div class="flex-shrink-0 w-[400px]">
    <div class="flex flex-col space-y-2 items-start bg-white rounded-lg shadow-md p-4">
        <img src="{{ $imageUrl }}" alt="{{ $title }}" class="w-full h-[200px] object-cover rounded-lg">
        <h3 class="text-lg font-semibold text-black">{{ $title }}</h3>
        <div class="flex justify-between items-center w-full">
            <span class="text-gray-800 text-lg font-semibold">${{ number_format($currentBid) }}</span>
            <button
                class="text-white px-6 py-2 rounded border-none bg-[#135d3b] hover:bg-[#135d3b]/75 transition-colors flex items-center active:scale-95">
                Bid Now
            </button>
        </div>
    </div>
</div>
