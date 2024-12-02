<div class="mt-6">
  <div class="bg-white shadow-lg rounded-lg p-2">
    <h4 class="text-lg font-semibold mb-4">Your Auctions</h4>

    <x-slide.slide width="100%" height="470px">
      @foreach (auth()->user()->ownAuction as $auction)
      <x-slide.slide-item
        :title="$auction->title"
        :currentBid="$auction->current_bid"
        :imageUrl="asset('' . $auction->primaryImage())"
        :buttonAction="route('auctions.show', $auction->id)"
        size="w-[300px]"
        :auction="$auction"
        height="h-[200px]"
        :isOwner="true" /> @endforeach
    </x-slide.slide>
    <button onclick="window.location.href='{{ route('auctions.create_auction') }}'" class="btn btn-success">Create New Auction</button>
  </div>
</div>
