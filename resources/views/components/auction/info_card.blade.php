<div class="flex-1 flex-col bg-white shadow-md rounded p-6 space-y-6 max-w-[26rem] min-w-[22rem]">
    <div class="h-2 bg-[#135d3b] rounded-t-md -mt-6 -mx-6 mb-6"></div>
    <div id="auction-data" data-auction-id="{{ $auction->id }}"
        data-auction-url="{{ route('auction_state.fetch', ['id' => $auction->id]) }}">
    </div>

    <!-- Start Price -->
    <div class="flex items-baseline justify-between">
        <span class="text-gray-600 text-lg">Start Price: </span>
        <span class="text-gray-800 text-lg font-semibold">
            $ {{ number_format($auction->start_price, 2) }}
        </span>
    </div>

    <!-- Category -->
    <div class="flex items-baseline justify-between">
        <span class="text-gray-600 text-lg">Category: </span>
        <span class="text-gray-800 text-lg font-semibold">
            {{ $auction->categoryName() ?? 'Uncategorized' }}
        </span>
    </div>

    <!-- Start Date -->
    <div class="flex items-baseline justify-between">
        <span class="text-gray-600 text-lg">Start Date: </span>
        <span class="text-gray-800 text-lg font-semibold">
            {{ $auction->start_date->format('d M Y, H:i') }}
        </span>
    </div>

    <!-- End Date -->
    <div class="flex items-baseline justify-between">
        <span class="text-gray-600 text-lg">End Date: </span>
        <span class="text-gray-800 text-lg font-semibold">
            {{ $auction->end_date ? $auction->end_date->format('d M Y, H:i') : 'No end date specified' }}
        </span>
    </div>

    <!-- State -->
    <div class="flex items-baseline justify-between">
        <span class="text-gray-600 text-lg">State: </span>
        <span id="auction-state" class="text-gray-800 text-lg font-semibold capitalize">
            {{ $auction->state }}
        </span>
    </div>

    <!-- Follow Button -->
    @auth
        @if (Auth::id() !== $auction->owner_id)
            <form class="flex items-center w-full" action="{{ route('auctions.follow', $auction) }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center space-x-8 py-1 text-gray-800 hover:bg-[#135d3b]/15 rounded-lg focus:outline-none active:scale-95 transition-all duration-150 ease-out
                    {{ Auth::user()->followsAuction()->where('auction_id', $auction->id)->exists()? 'border border-[#135d3b]': '' }}">
                    <span class="text-lg">Follow Auction</span>
                    @if (Auth::user()->followsAuction()->where('auction_id', $auction->id)->exists())
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">
                            notifications_active
                        </span>
                    @else
                        <span class="material-symbols-outlined">
                            notifications
                        </span>
                    @endif
                </button>
            </form>
        @endif
    @endauth

    <!-- Report Button -->
    @if (Auth::check() && Auth::id() !== $auction->owner_id)
        <x-toast.confirm :buttonText="'Report Auction'" :route="'auction.report'" :method="'POST'" :id="$auction->id" :modalTitle="'Report this auction?'"
            :modalMessage="'Are you sure you want to report the user?'" :textFlag="true" :object="$auction"
            class="flex items-center justify-center py-1 text-gray-800 text-lg bg-red-500/30 hover:bg-red-500/80 rounded-lg w-full active:scale-95 transition-all duration-150 ease-out" />
    @endif
</div>
