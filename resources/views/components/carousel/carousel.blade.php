@props(['items'])

<div class="relative w-full" id="carousel">
    <div class="overflow-hidden">
        <div class="flex transition-transform duration-300" id="carousel-inner">
            @foreach ($items as $item)
            <div class="w-full flex-shrink-0">
                <x-carousel.carousel-slide
                    :title="$item['title']"
                    :description="$item['description']"
                    :button-action="$item['buttonAction']"
                    :image-url="$item['imageUrl']" />
            </div>
            @endforeach
        </div>
    </div>

    <!-- Dots -->
    <div class="flex justify-center mt-4 gap-2" id="carousel-dots">
        @foreach ($items as $index => $item)
        <button
            onclick="goToSlide('{{ $index }}')"
            class="w-3 h-3 rounded-full {{ $index === 0 ? 'bg-black' : 'bg-gray-300' }} carousel-dot"
            data-index="{{ $index }}"></button>
        @endforeach
    </div>
</div>