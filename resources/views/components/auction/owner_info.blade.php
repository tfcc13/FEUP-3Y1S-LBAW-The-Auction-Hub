@props(['auction', 'owner' => false])

<div class="flex-1 flex-col bg-white shadow-md rounded p-6 space-y-6 max-w-[26rem] min-w-[22rem]">
    <div class="h-2 bg-[#135d3b] rounded-t-md -mt-6 -mx-6 mb-6"></div>

    <!-- Title -->
    <h2 class="text-xl font-semibold text-gray-800">Owner Info</h2>

    <!-- Owner Info -->
    <div class="flex items-center justify-between">
        @if ($auction->user->profile_image)
            <img src="{{ asset('storage/' . $auction->user->profile_image) }}" alt="{{ $auction->user->name }}"
                class="w-16 rounded-full">
        @else
            <img src="{{ asset('/images/defaults/default-profile.jpg') }}" alt="{{ $auction->user->name }}"
                class="w-16 rounded-full">
        @endif
        <span class="text-gray-800 text-xl font-bold">{{ $auction->user->name }}</span>
    </div>

    <!-- Seller Rating -->
    <div class="flex items-baseline justify-between">
        <span class="text-gray-600 text-xl">Seller Rating: </span>
        <span class="text-gray-800 text-xl font-bold">
            {{ $auction->user->rating ? number_format($auction->user->rating, 1) : 'No rating' }}
        </span>
    </div>

    {{-- Report Button --}}
    <x-toast.confirm :buttonText="'Report'" :route="'auction.report'" :method="'POST'" :id="$auction->id" :modalTitle="'Report this auction?'"
        :modalMessage="'Are you sure you want to report the user?'" :textFlag="true" :object="$auction" />
</div>
