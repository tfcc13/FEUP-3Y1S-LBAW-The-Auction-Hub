<div id="notificationToast" class="fixed top-24 right-4 z-50 hidden">
    <div class="bg-white text-gray-800 p-4 rounded-lg shadow-lg w-96 flex items-center justify-between">
        <div class="w-2 bg-[#135d3b] rounded-l-lg h-full absolute left-0"></div>
        <div>
            <strong class="font-bold text-gray-900">New Notification</strong>
            <p class="text-sm text-gray-600" id="toastMessage">Your bid has been placed!</p>
        </div>
        <div class="flex space-x-4 ml-4">
            <!-- Go to Auction Button -->
            <button id="goToAuction"
                class="text-[#135d3b] hover:text-[#0e4a28] font-medium hover:scale-105 active:scale-95">
                View
            </button>

            <!-- Close Button -->
            <button id="closeToast" class="text-gray-400 hover:text-gray-600 hover:scale-105 active:scale-95">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    let userId = null;

    @if (auth()->check())
        userId = '{{ auth()->user()->id }}';
    @endif


    const pusher = new Pusher(pusherAppKey, {
        cluster: pusherCluster,
        encrypted: true,
        logToConsole: true,
    });

    const channel = pusher.subscribe('the-auction-hub');

    const notificationQueue = [];
    let isNotificationActive = false;

    if (userId) {
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

                console.log(`notification-transaction-state-${userId}`)
                channel.bind(`notification-transaction-state-${userId}`, data => {
                    queueNotification(data.message, null);
                    //showNotification(data.message, null);
                });

                console.log(`notification-auction-win-${userId}`)
                channel.bind(`notification-auction-win-${userId}`, data => {

                    queueNotification(data.message, data._auction_id);
                    //showNotification(data.message, data._auction_id);
                });

                if (relatedAuctions.length === 0) {
                    console.log('No auctions to subscribe to (user may not be logged in).');
                    return;
                }


                relatedAuctions.forEach(auction => {
                    console.log(`notification-bid-${auction}`);

                    channel.bind(`notification-bid-${auction}`, data => {
                        queueNotification(data.message, `/auctions/auction/${data.auction_id}`);
                        //showNotification(data.message, `/auctions/auction/${data.auction_id}`);
                    });
                    channel.bind(`notification-auction-ended-${auction}`, data => {
                        queueNotification(data.message, `/auctions/auction/${data.auction_id}`);
                        //showNotification(data.message, `/auctions/auction/${data.auction_id}`);
                    });
                });
            })
            .catch(error => console.error('Error fetching related auctions:', error));



        function queueNotification(message, auctionLink) {
            notificationQueue.push({
                message,
                auctionLink
            });
            processNotificationQueue();
        }

        function processNotificationQueue() {
            if (isNotificationActive || notificationQueue.length === 0) {
                return;
            }
        }

        function processNotificationQueue() {
            if (isNotificationActive || notificationQueue.length === 0) {
                return;
            }
            const {
                message,
                auctionLink
            } = notificationQueue.shift();
            showNotification(message, auctionLink);
        };


        // Function to show notifications
        function showNotification(message, auctionLink) {
            const toast = document.getElementById('notificationToast');
            const goToAuctionButton = document.getElementById('goToAuction');
            document.getElementById('toastMessage').innerText = message;

            if (auctionLink) {
                goToAuctionButton.classList.remove('hidden');
                goToAuctionButton.onclick = () => {
                    window.location.href = auctionLink;
                };
            } else {
                goToAuctionButton.classList.add('hidden');
                goToAuctionButton.onclick = null; // Remove any previous event handlers
            }

            toast.classList.remove('hidden');
            isNotificationActive = true;

            document.getElementById('closeToast').onclick = () => {
                toast.classList.add('hidden');
                isNotificationActive = false;
                processNotificationQueue();
            };

            setTimeout(() => {
                toast.classList.add('hidden');
                isNotificationActive = false;
                processNotificationQueue();
            }, 10000);
        }
    }
</script>
