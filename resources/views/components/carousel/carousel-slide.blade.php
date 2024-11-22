@props(['title', 'description', 'buttonAction', 'imageUrl'])

<div class="grid grid-cols-2 gap-8 items-center carousel-slide px-8" id="carouselSlide">
    <div class="flex flex-col justify-between h-full p-28">
        <h2 class="text-7xl font-bold text-black overflow-hidden">{{ $title }}</h2>
        <div class="space-y-12">
            <p class="text-gray-600 text-3-5xl line-clamp-3">{{ $description }}</p>
            <button onclick="{{ $buttonAction }}"
                class="text-white text-2xl px-8 py-5 rounded-lg border-none bg-[#135d3b] hover:bg-[#135d3b]/75 transition-colors flex items-center active:scale-95">
                View Auction
            </button>
        </div>
    </div>
    <div class="flex justify-center items-center">
        <img src="{{ $imageUrl }}" alt="{{ $title }}" class="h-[60vh] aspect-[4/3] object-cover rounded-xl"
            draggable="false" onload="adjustImageFit(this)" />
    </div>
</div>

<style>
    .text-3-5xl {
        font-size: 2rem;
        line-height: 2.375rem;
    }
</style>

<script>
    function adjustImageFit(img) {
        if (img.naturalHeight > img.naturalWidth) {
            img.style.objectFit = 'scale-down';
        } else {
            img.style.objectFit = 'cover';
        }
    }
</script>
