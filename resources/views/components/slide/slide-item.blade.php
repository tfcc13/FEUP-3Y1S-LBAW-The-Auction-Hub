@props([
    'title',
    'auction',
    'currentBid',
    'imageUrl',
    'buttonAction',
    'endDate' => '',
    'isOwner' => false,
    'searchResults' => false,
])

<article class="flex-shrink-0 {{ $searchResults ? 'w-[370px]' : 'w-[400px]' }}" role="listitem">
    <section
        class="flex flex-col {{ $searchResults ? 'space-y-2 p-2' : 'space-y-4 p-4' }} items-start bg-white rounded-lg shadow-md select-none">
        {{-- Auction image --}}
        <figure class="w-full">
            <img src="{{ $imageUrl }}" alt="Auction item: {{ $title }}"
                class="w-full aspect-[4/3] object-cover rounded-xl select-none" draggable="false"
                onload="adjustImageFit(this)" loading="lazy">
        </figure>

        {{-- Auction title --}}
        <header class="auction-title">
            <span
                class="text-gray-800 {{ $searchResults ? 'text-lg' : 'text-xl' }} font-semibold select-none line-clamp-1">
                {{ $title }}
            </span>
        </header>

        {{-- Current bid amount --}}
        @if ($searchResults)
            <div class="flex items-baseline gap-3">
                <span class="font-medium">End date: </span>
                <span class="text-gray-600 select-none {{ $searchResults ? 'text-lg' : 'text-2xl' }}"
                    aria-label="End date">
                    {{ $endDate }}
                </span>
            </div>
        @endif

        {{-- Footer --}}
        <footer class="flex justify-between items-center w-full">
            {{-- Current bid amount --}}
            @if ($searchResults)
                <div class="flex items-baseline gap-3">
                    <span class="font-medium">Current bid: </span>
                    <span class="text-gray-600 select-none text-lg" aria-label="Current bid amount">
                        ${{ number_format($currentBid, 2) }}
                    </span>
                </div>
            @else
                <span class="text-gray-600 select-none text-2xl" aria-label="Current bid amount">
                    ${{ number_format($currentBid, 2) }}
                </span>
            @endif

            {{-- Bid button --}}
            <button
                class="text-white {{ $searchResults ? 'px-3 py-1' : 'px-6 py-2' }} rounded border-none bg-[#135d3b] hover:bg-[#135d3b]/75 transition-colors flex items-center active:scale-95 select-none"
                aria-label="Place bid for {{ $title }}" onclick="window.location.href='{{ $buttonAction }}'">
                {{ !$isOwner ? 'Bid Now' : 'View Details' }}
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
