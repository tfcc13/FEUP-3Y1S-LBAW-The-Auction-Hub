@props(['items'])

<div class="flex flex-col items-center w-full space-y-16 overflow-x-hidden" id="carousel">
    <div class="flex transition-all duration-300" id="carousel-inner">
        @foreach ($items as $item)
            <div class="w-full flex-shrink-0">
                <x-carousel.carousel-slide :title="$item['title']" :description="$item['description']" :button-action="$item['buttonAction']" :image-url="$item['imageUrl']" />
            </div>
        @endforeach
    </div>

    <!-- Dots -->
    <div class="flex w-full justify-center gap-14 transition-all duration-300" id="carousel-dots">
        @foreach ($items as $index => $item)
            <button onclick="goToSlide('{{ $index }}')"
                class="w-96 h-2 {{ $index === 0 ? 'bg-[#135d3b]' : 'bg-gray-200' }} focus:bg-[#135d3b] hover:bg-[#135d3b]/75 border-none carousel-dot"
                data-index="{{ $index }}">
            </button>
        @endforeach
    </div>
</div>
