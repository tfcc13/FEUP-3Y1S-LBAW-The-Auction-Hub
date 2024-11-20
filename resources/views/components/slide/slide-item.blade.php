@props(['title', 'currentBid', 'imageUrl', 'buttonAction'])

<div class="flex-shrink-0 w-[400px]">
    <div class="flex flex-col space-y-8 items-start bg-white rounded-lg shadow-md p-4 select-none">
        <img src="{{ $imageUrl }}" alt="{{ $title }}" class="aspect-[4/3] object-cover rounded-xl select-none" draggable="false" onload="adjustImageFit(this)">
        <h5 class="text-gray-800 font-semibold select-none">{{ $title }}</h5>
        <div class="flex justify-between items-center w-full">
            <span class="text-gray-600 text-3xl font-semibold select-none">${{ number_format($currentBid) }}</span>
            <button
                class="text-white px-6 py-2 rounded border-none bg-[#135d3b] hover:bg-[#135d3b]/75 transition-colors flex items-center active:scale-95 select-none">
                Bid Now
            </button>
        </div>
    </div>
</div>

<script>
    function adjustImageFit(img) {
        if (img.naturalHeight > img.naturalWidth) {
            img.style.objectFit = 'scale-down';
        } else {
            img.style.objectFit = 'cover';
        }
    }
</script>
