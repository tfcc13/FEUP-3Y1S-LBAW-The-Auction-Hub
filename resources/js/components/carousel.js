export default class Carousel {
    constructor(container) {
        this.container = container;
        this.inner = container.querySelector('#carousel-inner');
        this.currentSlide = 0;
        this.slides = container.querySelectorAll('.carousel-slide');
        this.dots = container.querySelectorAll('.carousel-dot');
        
        // Touch handling properties
        this.touchStartX = 0;
        this.touchEndX = 0;
        this.isDragging = false;
        this.dragThreshold = 50; // Minimum distance to trigger slide
        
        this.initializeCarousel();
    }

    initializeCarousel() {
        // Start auto-sliding
        this.autoSlideInterval = setInterval(() => this.moveSlide(1), 7500);
        
        // Add click listeners to dots
        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => this.goToSlide(index));
        });

        // Add touch event listeners
        this.inner.addEventListener('touchstart', (e) => this.handleTouchStart(e));
        this.inner.addEventListener('touchmove', (e) => this.handleTouchMove(e));
        this.inner.addEventListener('touchend', (e) => this.handleTouchEnd(e));
    }

    handleTouchStart(e) {
        this.touchStartX = e.touches[0].clientX;
        this.isDragging = true;
        this.inner.style.transition = 'none'; // Remove transition for immediate response
        
        // Pause auto-sliding during touch interaction
        if (this.autoSlideInterval) {
            clearInterval(this.autoSlideInterval);
        }
    }

    handleTouchMove(e) {
        if (!this.isDragging) return;
        
        e.preventDefault();
        const currentX = e.touches[0].clientX;
        const diff = this.touchStartX - currentX;
        const offset = -(this.currentSlide * 100 + (diff / this.inner.offsetWidth) * 100);
        
        // Apply the transform with boundaries
        this.inner.style.transform = `translateX(${offset}%)`;
    }

    handleTouchEnd(e) {
        if (!this.isDragging) return;
        
        this.isDragging = false;
        this.inner.style.transition = ''; // Restore transition
        
        const diff = this.touchStartX - e.changedTouches[0].clientX;
        
        if (Math.abs(diff) > this.dragThreshold) {
            // If dragged far enough, move to next/previous slide
            this.moveSlide(diff > 0 ? 1 : -1);
        } else {
            // If not dragged far enough, snap back
            this.updateCarousel();
        }
        
        // Restart auto-sliding
        this.autoSlideInterval = setInterval(() => this.moveSlide(1), 7500);
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
                dot.blur();
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
        
        // Remove touch event listeners
        this.inner.removeEventListener('touchstart', this.handleTouchStart);
        this.inner.removeEventListener('touchmove', this.handleTouchMove);
        this.inner.removeEventListener('touchend', this.handleTouchEnd);
    }
}