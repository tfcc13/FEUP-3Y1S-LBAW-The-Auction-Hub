@props(['items'])

<section class="flex flex-col items-center w-full space-y-8 overflow-hidden h-[70vh]" id="carousel"
    aria-label="Featured auctions carousel">
    <main class="flex transition-all duration-300" id="carousel-inner" role="region" aria-roledescription="carousel">
        @foreach ($items as $item)
            <article class="w-full flex-shrink-0" role="tabpanel" aria-roledescription="slide"
                aria-label="Slide {{ $loop->iteration }} of {{ count($items) }}">
                <x-carousel.carousel-slide :title="$item['title']" :description="$item['description']" :button-action="$item['buttonAction']" :image-url="$item['imageUrl']" />
            </article>
        @endforeach
    </main>

    <!-- Navigation Dots -->
    <nav class="flex w-full justify-center gap-14 transition-all duration-300" id="carousel-dots"
        aria-label="Carousel navigation">
        @foreach ($items as $index => $item)
            <button onclick="goToSlide('{{ $index }}')"
                class="w-96 h-2 {{ $index === 0 ? 'bg-[#135d3b]' : 'bg-gray-200' }} focus:bg-[#135d3b] hover:bg-[#135d3b]/75 border-none carousel-dot"
                data-index="{{ $index }}" aria-label="Go to slide {{ $index + 1 }}"
                aria-selected="{{ $index === 0 ? 'true' : 'false' }}" role="tab">
            </button>
        @endforeach
    </nav>
</section>
