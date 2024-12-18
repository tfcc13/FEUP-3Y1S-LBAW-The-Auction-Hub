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

        <form class="flex flex-col space-y-4" method="POST" action="{{ route('auction.update', $auction->id) }}">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="flex flex-col w-full">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
                <input type="text" id="title" name="title" class="form-input "
                    value="{{ old('title', $auction->title) }}" required>
            </div>

            <!-- Description -->
            <div class="flex flex-col w-full">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea id="description" name="description" rows="5" class="form-input" required>{{ old('description', $auction->description) }}</textarea>
            </div>

            <!-- Category -->
            <div class="flex flex-col w-full">
                <label for="category_id" class="block text-gray-700 font-semibold mb-2">Category</label>
                <select id="category_id" name="category_id" class="form-input" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $category->id == old('category_id', $auction->category_id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                class="w-min text-nowrap bg-[#135d3b] text-white rounded-lg px-4 !mt-10 py-2 active:scale-95 hover:bg-[#135d3b]/85 transition-all duration-150 ease-out">Update
                Auction</button>
        </form>
    </div>
@endsection
