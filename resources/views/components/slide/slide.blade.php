@props(['width' => '97%', 'height' => '450px', 'gap' => '10px'])

<section class="slider-container" aria-label="Auction items slider" style="width: {{ $width }}; height: {{ $height }};">
  <main class="inner-slider" role="region" aria-roledescription="slider" style="gap: {{ $gap }};">
    {{ $slot }}
  </main>
</section>

<style>
  .slider-container {
    position: relative;
    overflow: hidden;
    cursor: grab;
  }

  .inner-slider {
    width: max-content;
    display: flex;
    position: relative;
    left: 0;
    transition: left 0.1s ease-out;
  }
</style>
</style>
