@props(['title', 'currentBid', 'imageUrl', 'buttonAction', 'size' => 'w-[400px]', 'height' => 'h-[280px]'])

<article class="flex-shrink-0 {{ $size }} {{ $height }}" role="listitem">
    <section class="flex flex-col space-y-4 items-start bg-white rounded-lg shadow-md p-4 select-none">
        <figure class="{{ $height }}" style="position: relative; overflow: hidden;">
            <img src="{{ $imageUrl }}" alt="Auction item: {{ $title }}"
                class=" {{ $height }} w-full rounded-xl select-none" draggable="false"
                onload="adjustImageFit(this)" loading="lazy">
        </figure>
        <header>
            <h5 class="text-gray-800 font-semibold select-none line-clamp-1">{{ $title }}</h5>
        </header>
        <footer class="flex justify-between items-center w-full">
            <span class="text-gray-600 text-3xl font-semibold select-none" aria-label="Current bid amount">
                ${{ number_format($currentBid, 2) }}
            </span>
            <button
                class="text-white px-6 py-2 rounded border-none bg-[#135d3b] hover:bg-[#135d3b]/75 transition-colors flex items-center active:scale-95 select-none"
                aria-label="Place bid for {{ $title }}" 
                onclick="window.location.href='{{ $buttonAction }}'">
                Bid Now
            </button>
        </footer>
    </section>
</article>

<script>
    function adjustImageFit(img) {
        // Ensure the image keeps the aspect ratio correct
        const aspectRatio = img.naturalWidth / img.naturalHeight;

        if (img.naturalHeight > img.naturalWidth) {
            img.style.objectFit = 'scale-down';
        } else {
            img.style.objectFit = 'fill';
        }

        // Maintain aspect ratio by adjusting the height
        img.style.height = 'auto';
        img.style.aspectRatio = aspectRatio;
    }
</script>
