<div id="notificationToast" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-[#135d3b] text-white p-6 rounded-lg shadow-lg w-full max-w-md flex items-center justify-between">
        <div>
            <strong class="font-bold">New bid</strong>
            <p class="text-sm" id="toastMessage">Your bid has been placed!</p>
        </div>
        <div class="flex space-x-4">
            <!-- Close Button -->
            <button id="closeToast" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                Close
            </button>
            <!-- Go to Auction Button -->
            <button id="goToAuction" class="px-4 py-2 rounded bg-[#135d3b] hover:bg-[#0e4a28]">
                Go to Auction
            </button>
        </div>
    </div>
</div>

<script>
    const pusher = new Pusher(pusherAppKey, {
        cluster: pusherCluster,
        encrypted: true,
        logToConsole: true,
    });

    const channel = pusher.subscribe('the-auction-hub');

    channel.bind('notification-bid', function(data) {
        const message = data.message;
        const auctionId = data.auction_id;

        const toast = document.getElementById('notificationToast');
        const closeToastBtn = document.getElementById('closeToast');
        const goToAuctionBtn = document.getElementById('goToAuction');
        
        document.getElementById('toastMessage').innerText = message;

        toast.classList.remove('hidden');
        
        closeToastBtn.addEventListener('click', () => {
            toast.classList.add('hidden');
        });

        goToAuctionBtn.addEventListener('click', () => {
            window.location.href = '/auctions/auction/'+auctionId; 
        });

        setTimeout(() => {
            toast.classList.add('hidden');
        }, 10000); 
    });
</script>
