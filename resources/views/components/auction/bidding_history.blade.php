@props(['auction', 'owner' => false])

<div class="flex-1 flex-col bg-white shadow-md rounded p-6 space-y-6 max-w-[26rem] min-w-[22rem]">
    <div class="h-2 bg-[#135d3b] rounded-t-md -mt-6 -mx-6 mb-6"></div>

    <!-- Title -->
    <h2 class="text-xl font-semibold text-gray-800">Bidding History</h2>

    <!-- Bidding History -->
    @if ($auction->bids->isNotEmpty())
        <div class="space-y-3">
            @php
                $bids = $auction->bids->sortByDesc('amount');
                $visibleBids = $bids->take(3);
                $hasMoreBids = $bids->count() > 3;
            @endphp

            <div id="visible-bids-{{ $auction->id }}">
                @foreach ($visibleBids as $bid)
                    <div class="grid grid-cols-[minmax(0,_1fr)_minmax(0,_1fr)_minmax(0,_1fr)] *:font-medium *:text-gray-800">
                        <span class="truncate pr-2">{{ $bid->user->name }}</span>
                        <span class="text-right text-nowrap pl-2">{{ $bid->bid_date->format('M d, g:i A') }}</span>
                        <span class="text-right text-nowrap">${{ number_format($bid->amount, 2) }}</span>
                    </div>
                @endforeach
            </div>

            @if ($hasMoreBids)
                <button onclick="toggleBids('{{ $auction->id }}')" id="toggle-button-{{ $auction->id }}"
                    class="w-full flex items-center justify-center space-x-2 text-[#135d3b]">
                    <span id="button-text-{{ $auction->id }}">Show More</span>
                    <svg id="button-icon-{{ $auction->id }}" class="w-4 h-4 transform transition-transform rotate-180"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="hidden-bids-{{ $auction->id }}" class="hidden space-y-3">
                    @foreach ($bids->skip(3) as $bid)
                        <div class="grid grid-cols-[minmax(0,_1fr)_minmax(0,_1fr)_minmax(0,_1fr)] *:font-medium *:text-gray-800">
                            <span class="truncate pr-2">{{ $bid->user->name }}</span>
                            <span class="text-right text-nowrap pl-2">{{ $bid->bid_date->format('M d, g:i A') }}</span>
                            <span class="text-right text-nowrap">${{ number_format($bid->amount, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <p class="text-gray-600">No bids placed yet.</p>
    @endif
</div>

<script>
    function toggleBids(auctionId) {
        const hiddenBids = document.getElementById(`hidden-bids-${auctionId}`);
        const buttonText = document.getElementById(`button-text-${auctionId}`);
        const buttonIcon = document.getElementById(`button-icon-${auctionId}`);

        if (hiddenBids.classList.contains('hidden')) {
            hiddenBids.classList.remove('hidden');
            buttonText.textContent = 'Show Less';
            buttonIcon.style.transform = 'rotate(0deg)';
        } else {
            hiddenBids.classList.add('hidden');
            buttonText.textContent = 'Show More';
            buttonIcon.style.transform = 'rotate(180deg)';
        }
    }
</script>
