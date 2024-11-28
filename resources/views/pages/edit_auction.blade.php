@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Edit Auction</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('auction.update', $auction->id) }}">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="{{ old('title', $auction->title) }}" 
                required>
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea 
                id="description" 
                name="description" 
                rows="5"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>{{ old('description', $auction->description) }}</textarea>
        </div>
        
        <!-- Category -->
        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 font-semibold mb-2">Category</label>
            <select 
                id="category_id" 
                name="category_id" 
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ $category->id == old('category_id', $auction->category_id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Auction</button>
    </form>
</div>
@endsection
