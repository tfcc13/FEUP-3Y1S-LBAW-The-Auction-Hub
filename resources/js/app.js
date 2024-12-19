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
/* 
const pusher = new Pusher(pusherAppKey, {
    cluster: pusherCluster,
    encrypted: true,
    logToConsole: true,
});

const channel = pusher.subscribe('the-auction-hub');

channel.bind('notification-bid', function(data) {
    const message = data.message;

    const toast = document.createElement('div');
    toast.classList.add('toast');
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.right = '20px';
    toast.style.padding = '15px 25px';
    toast.style.backgroundColor = '#333';
    toast.style.color = '#fff';
    toast.style.borderRadius = '8px';
    toast.style.zIndex = '1000';
    toast.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.3)';
    toast.style.transition = 'opacity 0.5s ease-in-out';
    toast.style.display = 'flex';
    toast.style.flexDirection = 'column';
    toast.style.maxWidth = '300px';

    // Content for the toast
    toast.innerHTML = `
        <strong>New bid</strong>
        <p>${message}</p>
        <div style="display: flex; justify-content: space-between; margin-top: 10px;">
            <button id="closeBtn" style="background-color: #ff4c4c; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 5px;">Close</button>
            <button id="auctionBtn" style="background-color: #4CAF50; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 5px;">Go to Auction</button>
        </div>
    `;

    // Append the toast to the body
    document.body.appendChild(toast);

    // Button to close the toast
    const closeBtn = document.getElementById('closeBtn');
    closeBtn.addEventListener('click', function() {
        toast.style.opacity = '0'; // Fading effect
        setTimeout(() => {
            document.body.removeChild(toast); // Remove after fade-out
        }, 500);
    });

    // Button to go to the auction
    const auctionBtn = document.getElementById('auctionBtn');
    auctionBtn.addEventListener('click', function() {
        // Replace this URL with your auction page URL
        window.location.href = '/auction'; // This will navigate to the auction page
    });

    // Automatically remove the toast after 10 seconds (if not closed by the user)
    setTimeout(() => {
        toast.style.opacity = '0'; // Fading effect
        setTimeout(() => {
            document.body.removeChild(toast); // Remove after fade-out
        }, 500);
    }, 10000); // Toast will auto-close after 10 seconds
});
 */