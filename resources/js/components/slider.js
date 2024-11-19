export default class Slider {
    constructor(container) {
        this.container = container;
        this.inner = container.querySelector('.inner-slider');
        this.pressed = false;
        this.startX = 0;
        this.x = 0;
        this.initialSliderLeft = 0;

        this.initializeEventListeners();
    }

    initializeEventListeners() {
        this.container.addEventListener("mousedown", (e) => this.handleMouseDown(e));
        window.addEventListener("mouseup", () => this.handleMouseUp());
        window.addEventListener("mousemove", (e) => this.handleMouseMove(e));
    }

    handleMouseDown(e) {
        this.pressed = true;
        this.startX = e.pageX - this.container.offsetLeft;
        this.initialSliderLeft = this.inner.offsetLeft;
        this.container.style.cursor = "grabbing";
        this.inner.style.transition = 'none';
    }

    handleMouseUp() {
        this.pressed = false;
        this.container.style.cursor = "grab";
        this.checkBoundary();
    }

    handleMouseMove(e) {
        if (!this.pressed) return;
        e.preventDefault();

        this.x = e.pageX - this.container.offsetLeft;
        const walk = this.x - this.startX;
        
        const outer = this.container.getBoundingClientRect();
        const inner = this.inner.getBoundingClientRect();
        const maxScroll = inner.width - outer.width;
        let newLeft = this.initialSliderLeft + walk;

        if (newLeft > 0) {
            newLeft = newLeft * 0.3;
        } else if (newLeft < -maxScroll) {
            const overScroll = -(newLeft + maxScroll);
            newLeft = -maxScroll - (overScroll * 0.3);
        }

        this.inner.style.left = `${newLeft}px`;
    }

    checkBoundary() {
        const outer = this.container.getBoundingClientRect();
        const inner = this.inner.getBoundingClientRect();
        const maxScroll = inner.width - outer.width;

        this.inner.style.transition = 'left 0.3s ease-out';
        
        if (parseInt(this.inner.style.left) > 0) {
            this.inner.style.left = "0px";
        } else if (inner.right < outer.right) {
            this.inner.style.left = `-${maxScroll}px`;
        }

        setTimeout(() => {
            this.inner.style.transition = 'left 0.1s ease-out';
        }, 300);
    }
} 