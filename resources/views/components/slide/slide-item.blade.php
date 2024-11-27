@props(['title', 'currentBid', 'imageUrl', 'buttonAction'])

<article class="flex-shrink-0 w-[400px]" role="listitem">
    <section class="flex flex-col space-y-4 items-start bg-white rounded-lg shadow-md p-4 select-none">
        <figure class="w-full">
            <img src="{{ $imageUrl }}" alt="Auction item: {{ $title }}"
                class="w-full aspect-[4/3] object-cover rounded-xl select-none" draggable="false"
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
        if (img.naturalHeight > img.naturalWidth) {
            img.style.objectFit = 'scale-down';
        } else {
            img.style.objectFit = 'cover';
        }
    }
</script>
