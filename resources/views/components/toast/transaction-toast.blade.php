<div id="notificationToast" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-[#135d3b] text-white p-6 rounded-lg shadow-lg w-full max-w-md flex items-center justify-between">
        <div>
            <strong class="font-bold">Notification</strong>
            <p class="text-sm" id="toastMessage"></p>
        </div>
        <div class="flex space-x-4">
            <!-- Close Button -->
            <button id="closeToast" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                Close
            </button>
            <!-- Go to Auction Button -->
            <button id="goToNotifications" class="px-4 py-2 rounded bg-[#135d3b] hover:bg-[#0e4a28]">
                Go to Notifications
            </button>
        </div>
    </div>
</div>

<script>
    let userId = null;

    @if(auth()->check())
        userId = '{{ auth()->user()->id }}';
    @endif

    const pusher = new Pusher(pusherAppKey, {
        cluster: pusherCluster,
        encrypted: true,
        logToConsole: true,
    });

    const channel = pusher.subscribe('the-auction-hub');
    console.log(`notification-transaction-state-${userId}`);
    if (userId) {
        console.log(`notification-transaction-state-${userId}`);
        channel.bind(`notification-transaction-state-${userId}`, data => {
            showNotification(data.message, `/notifications`);
        });
    }

    // Function to show notifications
    function showNotification(message, auctionLink) {
        const toast = document.getElementById('notificationToast');
        const toastMessage = document.getElementById('toastMessage');
        const closeToastButton = document.getElementById('closeToast');
        const goToAuctionButton = document.getElementById('goToNotifications');

        // Update the message
        if (toastMessage) {
            toastMessage.innerText = message;
        }

        // Show the toast
        if (toast) {
            toast.classList.remove('hidden');
        }

        // Close button handler
        if (closeToastButton) {
            closeToastButton.onclick = () => {
                toast.classList.add('hidden');
            };
        }

        // Go to auction button handler
        if (goToAuctionButton) {
            goToAuctionButton.onclick = () => {
                window.location.href = auctionLink;
            };
        }

        // Auto-hide after 10 seconds
        setTimeout(() => {
            if (toast) {
                toast.classList.add('hidden');
            }
        }, 10000);
    }
</script>