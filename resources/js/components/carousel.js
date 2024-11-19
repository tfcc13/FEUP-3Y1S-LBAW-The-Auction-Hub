export default class Carousel {
    constructor(container) {
        this.container = container;
        this.inner = container.querySelector('#carousel-inner');
        this.currentSlide = 0;
        this.slides = container.querySelectorAll('.carousel-slide');
        this.dots = container.querySelectorAll('.carousel-dot');
        
        this.initializeCarousel();
    }

    initializeCarousel() {
        // Start auto-sliding
        this.autoSlideInterval = setInterval(() => this.moveSlide(1), 7500);
        
        // Add click listeners to dots
        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => this.goToSlide(index));
        });
    }

    updateCarousel() {
        // Update slide position
        this.inner.style.transform = `translateX(-${this.currentSlide * 100}%)`;
        
        // Update dots
        this.dots.forEach((dot, index) => {
            if (index === this.currentSlide) {
                dot.classList.add('bg-[#135d3b]');
                dot.classList.remove('bg-gray-200');
            } else {
                dot.classList.remove('bg-[#135d3b]');
                dot.classList.add('bg-gray-200');
            }
        });
    }

    moveSlide(direction) {
        this.currentSlide = (this.currentSlide + direction + this.slides.length) % this.slides.length;
        this.updateCarousel();
    }

    goToSlide(index) {
        this.currentSlide = index;
        this.updateCarousel();
    }

    // Clean up method to clear interval when needed
    destroy() {
        if (this.autoSlideInterval) {
            clearInterval(this.autoSlideInterval);
        }
    }
} 