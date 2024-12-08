@props(['auction', 'owner' => false])

<div class="flex-1 flex-col bg-white shadow-md rounded p-6 space-y-6 max-w-[26rem] min-w-[22rem]">
    <div class="h-2 bg-[#135d3b] rounded-t-md -mt-6 -mx-6 mb-6"></div>

    <!-- Title -->
    <h2 class="text-xl font-semibold text-gray-800">Bidding History</h2>

    <!-- Bidding History -->
    @if ($auction->bids->isNotEmpty())
        <div class="space-y-3">
            @foreach ($auction->bids as $bid)
                <div class="flex items-center justify-between *:font-medium *:text-gray-800">
                    <p>{{ $bid->user->name }}</p>
                    <p>{{ $bid->bid_date->format('M d, g:i A') }}</p>
                    <p>${{ number_format($bid->amount, 2) }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">No bids placed yet.</p>
    @endif
</div>
