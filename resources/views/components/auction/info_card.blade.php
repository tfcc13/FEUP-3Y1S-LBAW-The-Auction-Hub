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
            <div class="flex items-center justify-between">
                <span class="text-gray-600 text-lg">Follow Auction:</span>
                <form action="{{ route('auctions.follow', $auction) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 text-gray-800 hover:text-gray-600 focus:outline-none">
                        @if (Auth::user()->followsAuction()->where('auction_id', $auction->id)->exists())
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd"
                                    d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        @endif
                    </button>
                </form>
            </div>
        @endif
    @endauth

    <!-- Report Button -->
    @if (Auth::check() && Auth::id() !== $auction->owner_id)
        <x-toast.confirm :buttonText="'Report Auction'" :route="'auction.report'" :method="'POST'" :id="$auction->id" :modalTitle="'Report this auction?'"
            :modalMessage="'Are you sure you want to report the user?'" :textFlag="true" :object="$auction" />
    @endif
</div>
