<div class="mt-6">
    <div class="bg-white shadow-lg rounded-lg p-2">
        <h4 class="text-lg font-semibold mb-4">Your Auctions</h4>

        <x-slide.slide>
            @foreach (auth()->user()->ownAuction as $auction)
                <x-slide.slide-item :title="$auction->title" :currentBid="$auction->current_bid" :imageUrl="asset('' . $auction->primaryImage())" :buttonAction="route('auctions.show', $auction->id)"
                    :auction="$auction" :isOwner="true" />
            @endforeach
        </x-slide.slide>
        <button onclick="window.location.href='{{ route('auctions.create_auction') }}'" class="btn btn-success">Create New
            Auction</button>
    </div>
</div>
