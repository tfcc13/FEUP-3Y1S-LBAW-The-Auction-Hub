<section class="slider-container" aria-label="Auction items slider">
    <main class="inner-slider" role="region" aria-roledescription="slider">
        {{ $slot }}
    </main>
</section>

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