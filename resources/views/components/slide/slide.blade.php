@props(['items'])

<div class="flex flex-col items-center w-full space-y-6">
    <h2 class="text-4xl font-bold text-gray-800">Featured Auctions</h2>
    <section class="slider-container" aria-label="Auction items slider">
        <main class="inner-slider" role="region" aria-roledescription="slider">
            @foreach ($items as $item)
                <x-slide.slide-item :title="$item['title']" :currentBid="$item['current_bid']" :imageUrl="$item['imageUrl']" :buttonAction="$item['buttonAction']" />
            @endforeach
        </main>
    </section>

</div>

<style>
    .slider-container {
        width: 97%;
        height: 450px;
        position: relative;
        overflow: hidden;
        cursor: grab;
    }

    .inner-slider {
        width: max-content;
        display: flex;
        gap: 10px;
        position: relative;
        left: 0;
        transition: left 0.1s ease-out;
    }
</style>
