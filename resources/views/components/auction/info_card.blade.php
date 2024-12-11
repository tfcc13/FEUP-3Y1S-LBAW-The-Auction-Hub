<div class="flex-1 flex-col bg-white shadow-md rounded p-6 space-y-6 max-w-[26rem] min-w-[22rem]">
    <div class="h-2 bg-[#135d3b] rounded-t-md -mt-6 -mx-6 mb-6"></div>
        <div id="auction-data" 
        data-auction-id="{{ $auction->id }}" 
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
        <span  id="auction-state" class="text-gray-800 text-lg font-semibold capitalize">
            {{ $auction->state }}
        </span>
    </div>
</div>
