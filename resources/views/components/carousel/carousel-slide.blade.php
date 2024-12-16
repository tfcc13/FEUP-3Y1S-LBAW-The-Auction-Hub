@props(['title', 'description', 'buttonAction', 'imageUrl'])

<article class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-8 items-center carousel-slide" id="carouselSlide">
    <section class="flex flex-col justify-between h-full p-4 sm:p-10">
        <header>
            <h2 class="text-3xl sm:text-6xl font-bold text-gray-800">{{ $title }}</h2>
        </header>
        <div class="space-y-4 sm:space-y-12">
            <p class="text-gray-600 text-xl sm:text-3xl line-clamp-3">{{ $description }}</p>
            <button onclick="window.location.href='{{ $buttonAction }}'"
                class="text-white text-lg sm:text-2xl px-4 py-3 rounded-lg border-none bg-[#135d3b] hover:bg-[#135d3b]/75 transition-colors flex items-center active:scale-95"
                aria-label="View auction details">
                View Auction
            </button>
        </div>
    </section>
    <figure class="flex justify-center items-center">
        <img src="{{ $imageUrl }}" alt="{{ $title }}"
            class="!h-[30vh] sm:!h-[65vh] !aspect-[4/3] !object-cover rounded-xl" draggable="false" onload="adjustImageFit(this)"
            loading="lazy" />
    </figure>
</article>

<script>
    function adjustImageFit(img) {
        if (img.naturalHeight > img.naturalWidth) {
            img.style.objectFit = 'scale-down';
        } else {
            img.style.objectFit = 'cover';
        }
    }
</script>
