@extends('layouts.app')

@section('content')
    <form class="flex flex-col p-6 space-y-8 items-center w-full" method="POST"
        action="{{ route('auctions.submit_auction') }}" enctype="multipart/form-data">
        <h2 class="text-xl font-semibold text-gray-800">Create a New Auction</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded">
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
                        <div id="startPriceError" class="text-red-600 text-sm mt-1 hidden"></div>
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
                {{-- Image Preview (hidden by default) --}}
                <div id="imagePreview" class="hidden w-full aspect-[4/3] bg-gray-100 mb-4 rounded-lg overflow-hidden">
                    <img id="previewImage" class="w-full h-full object-cover hidden select-none" alt="Preview"
                        onload="adjustImageFit(this)">
                </div>

                <label for="files" class="block text-gray-700 font-semibold">Upload Images</label>

                <input type="file" id="files" name="files[]" multiple class="form-input"
                    accept=".jpg,.jpeg,.png,.webp" required>
                <input name="type" type="text" value="auction" hidden>
                @error('files')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
                <div id="fileSizeError" class="text-red-600 text-sm mt-1 hidden"></div>
            </div>
        </div>

        {{-- Submit Button --}}
        <button type="submit" id="submit_button" class="bg-[#135d3b] text-white px-4 py-2 rounded-lg hover:bg-[#135d3b]/85">
            Create Auction
        </button>
    </form>


    <script>
        document.getElementById('files').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('imagePreview');
            const preview = document.getElementById('previewImage');
            const files = event.target.files;

            if (files && files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    previewContainer.classList.remove('hidden'); // Show the container
                }

                reader.readAsDataURL(files[0]);
            } else {
                preview.classList.add('hidden');
                previewContainer.classList.add('hidden'); // Hide the container
                preview.src = '';
            }
        });

        function adjustImageFit(img) {
            if (img.naturalHeight > img.naturalWidth) {
                img.style.objectFit = 'scale-down';
            } else {
                img.style.objectFit = 'cover';
            }
        }

        document.getElementById('files').addEventListener('change', function(event) {
        const maxSizeInBytes = 1024 * 1024 *2; 
        const errorContainer = document.getElementById('fileSizeError');
        const files = event.target.files;
        let fileTooLarge = false;

        for (let i = 0; i < files.length; i++) {
            if (files[i].size > maxSizeInBytes) {
                fileTooLarge = true;
                break;
            }
        }

        if (fileTooLarge) {
            errorContainer.textContent = 'One or more files exceed the 2MB size limit. Please select smaller files.';
            errorContainer.classList.remove('hidden');
            event.target.value = ''; 
        } else {
            errorContainer.classList.add('hidden');
        }
    });
    document.getElementById('start_price').addEventListener('input', function(event) {
        const startPriceInput = event.target;
        const submitButton = document.getElementById('submit_button');
        const errorContainer = document.getElementById('startPriceError');
        const maxDigits = 12;

        // Remove non-digit characters and count digits
        const digitCount = startPriceInput.value.replace(/\D/g, '').length;

        if (digitCount > maxDigits) {

            submitButton.disabled = true;
            errorContainer.textContent = 'Start Price cannot exceed 12 digits.';
            errorContainer.classList.remove('hidden');
        } else {

            submitButton.disabled = false;
            errorContainer.classList.add('hidden');
        }
    });
    </script>
@endsection
