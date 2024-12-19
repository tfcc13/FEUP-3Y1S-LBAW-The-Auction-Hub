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
const pusher = new Pusher(pusherAppKey, {
    cluster: pusherCluster,
    encrypted: true,
    logToConsole: true,
});

const channel = pusher.subscribe('the-auction-hub');

channel.bind('notification-bid', function(data) {
    const message = data.message;

    // Create the pop-up notification
    const notificationBox = document.createElement('div');
    notificationBox.classList.add('notification-box');
    notificationBox.style.position = 'fixed';
    notificationBox.style.bottom = '20px';
    notificationBox.style.right = '20px';
    notificationBox.style.padding = '10px 20px';
    notificationBox.style.backgroundColor = '#333';
    notificationBox.style.color = '#fff';
    notificationBox.style.borderRadius = '5px';
    notificationBox.style.zIndex = '1000';
    notificationBox.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.3)';
    notificationBox.style.transition = 'opacity 0.5s ease-in-out';

    notificationBox.innerHTML = `
        <strong>New bid</strong>
        <p>${message}</p>
    `;

    // Append the notification box to the body
    document.body.appendChild(notificationBox);

    // Make the notification fade out and remove after a certain duration
    setTimeout(() => {
        notificationBox.style.opacity = '0'; // Fading effect
        setTimeout(() => {
            document.body.removeChild(notificationBox); // Remove after fade-out
        }, 500); // Wait for the fade-out to finish
    }, 5000); // Show the notification for 5 seconds
});
