<div class="flex flex-col space-y-6 w-full p-4 sm:p-6">
    <!-- Top Row: Profile Picture, Details, and Rating -->
    <div class="flex flex-col sm:flex-row sm:space-x-8 items-start">
        <!-- User Profile Picture -->
        <div class="w-48 h-48 flex-shrink-0 mb-4 sm:mb-0">
            <x-user.image class="w-full h-full object-cover rounded-full" />
        </div>

        <!-- User Details and Rating -->
        <div class="flex-grow">
            <!-- User Details -->
            <div class="text-md font-bold text-gray-900 mb-2 sm:text-xl">
                <span class="mr-2">Name:</span>
                <span class="break-words">{{ auth()->user()->name }}</span>
            </div>

            <div class="text-md text-gray-500 font-bold mb-2 sm:text-xl">
                <span class="mr-2">Username:</span>
                <span class="break-words">{{ auth()->user()->username }}</span>
            </div>

            <div class="text-md text-gray-500 mb-4 sm:text-xl">
                <span class="mr-2 font-bold">Email:</span>
                <span class="break-words">{{ auth()->user()->email }}</span>
            </div>

            <!-- User Rating -->
            <div class="flex items-center text-gray-900 mb-4 sm:text-xl">
                <span class="mr-2 font-bold">Rating:</span>
                <div class="flex items-center">
                    @php
                        $rating = auth()->user()->rating ?? 0;
                        $fullStars = floor($rating);
                        $hasHalfStar = $rating - $fullStars >= 0.5;
                        $emptyStars = 5 - ceil($rating);
                    @endphp

                    @for ($i = 0; $i < $fullStars; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" fill="currentColor"
                            viewBox="0 0 24 24" stroke="none">
                            <path
                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    @endfor

                    @if ($hasHalfStar)
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" fill="currentColor"
                            viewBox="0 0 24 24" stroke="none">
                            <path
                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    @endif

                    @for ($i = 0; $i < $emptyStars; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path
                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Description Section -->
    <div class="border-t pt-6">
        <div class="flex flex-col space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-xl font-semibold text-gray-900">Description</span>
                <button
                    class="px-4 py-2 rounded-md text-white border border-gray-300 bg-[#135d3b] hover:bg-[#0d4429] focus:ring-2 focus:ring-gray-300 transition-colors"
                    data-modal-toggle="edit-description-modal">
                    Change Description
                </button>
            </div>
            <p class="text-gray-700">{{ auth()->user()->description ?? 'No description set' }}</p>
        </div>

        <!-- Modal to change description -->
        <div id="edit-description-modal"
            class="fixed inset-0 bg-gray-500 bg-opacity-50 justify-center items-center hidden z-50">
            <div class="bg-white rounded-lg p-6 shadow-lg max-w-lg w-full">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Edit Description</h2>

                <form action="{{ route('user.updateDescription') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <textarea name="description"
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="4">{{ auth()->user()->description ?? '' }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="button"
                            class="px-6 py-2 rounded-md text-white border border-gray-300 bg-gray-500 hover:bg-gray-600 focus:ring-2 focus:ring-gray-300 transition-colors"
                            onclick="document.getElementById('edit-description-modal').classList.add('hidden')">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2 rounded-md text-white border border-gray-300 bg-[#135d3b] hover:bg-[#0d4429] focus:ring-2 focus:ring-gray-300 transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleModal(show) {
        const modal = document.getElementById('edit-description-modal');
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Add event listener to the button
    document.querySelector('[data-modal-toggle="edit-description-modal"]').addEventListener('click', () => {
        toggleModal(true);
    });
</script>
