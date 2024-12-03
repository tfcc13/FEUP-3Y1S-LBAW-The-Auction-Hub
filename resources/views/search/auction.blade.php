@extends('layouts.app')

@section('content')
    <main class="flex flex-col items-center py-4 px-6 space-y-8">
        <!-- Categories section -->
        <x-categories.categories :categories="$categories" />

        <h1 class="text-4xl font-extrabold text-gray-800 mb-8 text-center">Search Results</h1>

        @if (isset($error))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                <p class="font-bold">Error</p>
                <p>{{ $error }}</p>
            </div>
        @elseif(isset($message))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded mb-6">
                <p>{{ $message }}</p>
            </div>
        @else
            <p class="mb-6 text-lg text-gray-700">
                Showing results for: <span class="font-semibold text-gray-900">"{{ $searchTerm }}"</span>
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($auctions as $auction)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-800 mb-3">{{ $auction['title'] }}</h2>
                            <p class="text-gray-600 mb-4">{{ Str::limit($auction['description'], 100) }}</p>
                            <a href="{{ asset('/auctions/auction/' . $auction['id']) }}"
                                class="inline-block px-4 py-2 text-white sm:text-base rounded-md bg-[#135d3b] hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                View Auction
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
@endsection
