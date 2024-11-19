import './bootstrap';
import Slider from './components/slider';
import Carousel from './components/carousel';

// Initialize components after DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sliders
    const sliderContainers = document.querySelectorAll('.slider-container');
    sliderContainers.forEach(container => new Slider(container));

    // Initialize carousels
    const carouselContainers = document.querySelectorAll('#carousel');
    carouselContainers.forEach(container => new Carousel(container));
});
