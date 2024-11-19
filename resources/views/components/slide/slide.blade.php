<div class="slider-container">
    <div class="inner-slider">
        {{ $slot }}
    </div>
</div>

<style>
    .slider-container {
        width: 95%;
        height: 350px;
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