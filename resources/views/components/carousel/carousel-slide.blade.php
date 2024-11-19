@props(['title', 'description', 'buttonAction', 'imageUrl'])

<div class="grid grid-cols-2 gap-8 items-center carousel-slide px-8">
    <div class="space-y-6">
        <h2 class="text-4xl font-bold text-black">{{ $title }}</h2>
        <p class="text-gray-600 text-3xl">{{ $description }}</p>
        <button
            onclick="{{ $buttonAction }}"
            class="text-white px-6 py-2 rounded border-none bg-[#135d3b] hover:bg-[#135d3b]/75 transition-colors flex items-center active:scale-95">
            View Auction
        </button>
    </div>
    <div class="border rounded-lg overflow-hidden">
        <img
            src="{{ $imageUrl }}"
            alt="{{ $title }}"
            class="w-full h-auto object-cover" />
    </div>
</div>