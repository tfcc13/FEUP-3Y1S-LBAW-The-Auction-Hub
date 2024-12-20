<div id="notificationToast" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-[#135d3b] text-white p-6 rounded-lg shadow-lg w-full max-w-md flex items-center justify-between">
        <div>
            <strong class="font-bold">New Notification</strong>
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
    if(userId){
        fetch('/auctions/related-auctions', {
            headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then(response => {
                    
                    console.log('Response status:', response.status, response.statusText);
                    if (!response.ok) throw new Error('Failed to fetch related auctions');
                    return response.json();
                })
                .then(relatedAuctions => {
                    if (relatedAuctions.length === 0) {
                        console.log('No auctions to subscribe to (user may not be logged in).');
                        return;
                    }

                    relatedAuctions.forEach(auction => {
                        console.log(`notification-bid-${auction}`);

                        channel.bind(`notification-bid-${auction}`, data => {
                            showNotification(data.message, `/auctions/auction/${data.auction_id}`);
                        });
                        channel.bind(`notification-auction-ended-${auction}`, data => {
                            showNotification(data.message, `/auctions/auction/${data.auction_id}`);
                        });
                    });
                })
                .catch(error => console.error('Error fetching related auctions:', error));

            // Function to show notifications
            function showNotification(message, auctionLink) {
                const toast = document.getElementById('notificationToast');
                document.getElementById('toastMessage').innerText = message;

                toast.classList.remove('hidden');

                document.getElementById('closeToast').onclick = () => {
                    toast.classList.add('hidden');
                };

                document.getElementById('goToAuction').onclick = () => {
                    window.location.href = auctionLink;
                };

                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 10000);
            }
        }
    
</script>
