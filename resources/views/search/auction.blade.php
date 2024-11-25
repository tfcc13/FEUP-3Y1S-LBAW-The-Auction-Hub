
@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-3xl font-bold mb-6">Search Results</h1>

    @if(isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <strong>Error:</strong> {{ $error }}
        </div>
    @elseif(isset($message))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            {{ $message }}
        </div>
    @else
        <p class="mb-4">Results for "<strong>{{ $searchTerm }}</strong>":</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($auctions as $auction)
                <div class="border rounded-lg shadow-lg p-4 bg-white">
                    <h2 class="text-xl font-bold mb-2">{{ $auction['title'] }}</h2>
                    <p class="text-gray-600">{{ $auction['description'] }}</p>
                    <a href="{{ url('/auctions/' . $auction['id']) }}" class="text-blue-500 hover:underline mt-4 inline-block">View Auction</a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
