@extends('layouts.app')

@section('content')
    <form class="flex flex-col p-6 space-y-8 items-center w-full" method="POST"
        action="{{ route('auctions.submit_auction') }}" enctype="multipart/form-data">
        <h2 class="text-xl font-semibold text-gray-800">Create a New Auction</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif



        @csrf
        <div
            class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-16 md:space-x-48 lg:space-x-80 w-full">
            <div class="flex flex-col space-y-4 w-full sm:w-[32rem]">
                {{-- Auction Title --}}
                <div class="flex flex-col justify-start space-y-1 w-full">
                    <label for="title" class="block text-gray-700 font-semibold">Auction Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-input"
                        required>
                    @error('title')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Auction Description --}}
                <div class="flex flex-col justify-start space-y-1 w-full">
                    <label for="description" class="block text-gray-700 font-semibold">Auction Description</label>
                    <textarea id="description" name="description" rows="4" class="form-input" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Start Price --}}
                <div class="flex flex-col justify-start space-y-1 w-full">
                    <label for="start_price" class="block text-gray-700 font-semibold">Start Price</label>
                    <input type="number" id="start_price" name="start_price" value="{{ old('start_price') }}"
                        min="0" step="0.01" class="form-input" required>
                    @error('start_price')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Category Selection --}}
                <div class="flex flex-col justify-start space-y-1 w-full">
                    <label for="category_id" class="block text-gray-700 font-semibold">Select Category</label>
                    <select id="category_id" name="category_id" class="form-input" required>
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Image Upload Field --}}
            <div class="flex flex-col space-y-2 w-full sm:w-[32rem]">
                <label for="files" class="block text-gray-700 font-semibold">Upload Images</label>
                <input type="file" id="files" name="files[]" multiple class="form-input">
                <input name="type" type="text" value="auction" hidden>
                @error('files')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Create Auction
        </button>
    </form>
@endsection
