@props(['auction', 'owner' => false])

<div class="flex-1 flex-col bg-white shadow-md rounded p-6 space-y-6 max-w-[26rem] min-w-[22rem]">
    <div class="h-2 bg-[#135d3b] rounded-t-md -mt-6 -mx-6 mb-6"></div>

    <!-- Auction Remaining Time -->
    <div class="flex items-baseline justify-between">
        <span class="text-gray-600 text-xl">Closes in: </span>
        <span class="auction-remaining-time text-gray-800 text-xl font-bold"></span>
        <span class="auction-end-time" hidden>{{ $auction->end_date->format('Y-m-d H:i:s') }}</span>
        <span class="auction-status" hidden>{{ $auction->state }}</span>
    </div>

    <!-- Current Bid -->
    <div class="flex items-baseline justify-between">
        <span class="text-gray-600 text-xl">Current Bid: </span>
        <span class="text-gray-800 text-xl font-bold">
            {{ $auction->bids->count() > 0 ? '$ ' . number_format($auction->bids->max('amount'), 2) : 'No bids yet' }}
        </span>
    </div>

    <!-- Bid Form -->
    @if (!$owner && !Auth::user()->is_admin && $auction->state === 'Ongoing')
        <form class="flex flex-col space-y-4" method="POST" action="{{ route('auction.bid', $auction->id) }}">
            @csrf
            <input type="hidden" name="auction_id" value="{{ $auction->id }}">

            <input type="number" id="amount" name="amount" step="0.01"
                min="{{ $auction->bids->max('amount') ? $auction->bids->max('amount') + 1 : $auction->start_price }}"
                class="form-input" required>

            <button type="submit"
                class="w-full bg-[#135d3b] text-white rounded-lg py-2 active:scale-95 hover:bg-[#135d3b]/85 transition-all duration-150 ease-out">
                Place Bid
            </button>
        </form>
    @elseif ($owner || Auth::user()->is_admin)
        <button
            class="w-full bg-[#135d3b] text-white rounded-lg py-2 active:scale-95 hover:bg-[#135d3b]/85 transition-all duration-150 ease-out"
            onclick="window.location.href='{{ route('auction.edit_auction', $auction->id) }}'">
            Edit Auction
        </button>
        @if ($auction->state === 'Ongoing')
            <form method="POST" action="{{ route('auction.cancel_auction', $auction->id) }}" class="mt-6">
                @csrf
                <button type="submit"
                    class="w-full bg-red-500 text-white rounded-lg py-2 active:scale-95 hover:bg-red-500/85 transition-all duration-150 ease-out">
                    Cancel Auction
                </button>
            </form>
        @endif
        <form method="POST" action="{{ route('auction.delete', $auction->id) }}" class="mt-6">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="w-full bg-red-700 text-white rounded-lg py-2 active:scale-95 hover:bg-red-700/85 transition-all duration-150 ease-out">
                Delete Auction
            </button>
        </form>
    @endif
</div>


<script>

document.addEventListener("DOMContentLoaded", function () {
    function updateBidCardRemainingTime() {
        const now = new Date();

        document.querySelectorAll(".auction-end-time").forEach((endTimeElement, index) => {
            const endTime = new Date(endTimeElement.textContent.trim());
            const remainingTime = endTime - now;

            const remainingTimeElement = document.querySelectorAll(".auction-remaining-time")[index];
            const statusElement = document.querySelectorAll(".auction-status")[index];

            if (!remainingTimeElement || !statusElement) return;

            if (statusElement.textContent.trim() === "Closed") {
                remainingTimeElement.textContent = "Auction ended.";
            } else if (remainingTime > 0) {
                const days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                if (days > 0) {
                    remainingTimeElement.textContent = `${days}d ${hours}h ${minutes}m`;
                } else if (hours > 0) {
                    remainingTimeElement.textContent = `${hours}h ${minutes}m ${seconds}s`;
                } else if (minutes > 0) {
                    remainingTimeElement.textContent = `${minutes}m ${seconds}s`;
                } else {
                    remainingTimeElement.textContent = `${seconds}s`;
                }
            } else {
                remainingTimeElement.textContent = "Auction Closing.";
            }
        });
    }

    // Initial setup for existing cards
    updateBidCardRemainingTime();
    setInterval(updateBidCardRemainingTime, 1000);
});

</script>
