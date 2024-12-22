<div class="flex flex-col space-y-6 w-full p-4 sm:p-6">
    <div
        class="grid grid-cols-1 sm:grid-cols-2 items-center justify-items-center sm:justify-items-start space-y-8 sm:space-y-0">
        <!-- User Profile Picture -->
        <div class="w-48 h-48 flex-shrink-0 items-center justify-center">
            <x-user.image class="w-full h-full object-cover rounded-full" />
        </div>
        <!-- User Details and Rating -->
        <x-user.user-details :name="auth()->user()->name" :username="auth()->user()->username" :email="auth()->user()->email"
            :rating="auth()->user()->rating"></x-user.user-details>
    </div>


    <button id="changeProfilePicBtn" type="button"
        class="w-min sm:w-min px-2 py-1 rounded-md text-white border border-gray-300 bg-[#135d3b] hover:bg-[#135d3b]/85 focus:ring-2 focus:ring-gray-300 transition-colors text-nowrap">
        Change Picture
    </button>
    <form id="profilePicForm" action="{{ route('user.profile.picture.update') }}" method="POST"
        enctype="multipart/form-data" hidden>
        @csrf
        <div class="form-group">
            <input type="file" name="file" id="file" class="form-control" required label="Profile Picture">
            <input name="type" type="text" value="user" hidden label="Type">
            @error('user')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit"
            class="w-min sm:w-auto px-2 py-1 rounded-md text-white border border-gray-300 bg-[#135d3b] hover:bg-[#135d3b]/85 focus:ring-2 focus:ring-gray-300 transition-colors text-nowrap">Upload</button>
    </form>
    <div id="fileSizeError" class="text-red-600 text-sm mt-1 hidden"></div>
    <!-- Description Section -->
    <div class="border-t pt-6">
        <div class="flex flex-col space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 items-center justify-items-start space-y-2 sm:space-y-0">
                <span class="text-xl font-semibold text-gray-900">Description</span>
                <button
                    class="w-min sm:w-auto px-4 py-2 rounded-md text-white border border-gray-300 bg-[#135d3b] hover:bg-[#135d3b]/85 focus:ring-2 focus:ring-gray-300 transition-colors text-nowrap"
                    data-modal-toggle="edit-description-modal">
                    Change Description
                </button>
            </div>
            <p class="text-gray-700">{{ auth()->user()->description ?? 'No description set' }}</p>
        </div>

        <!-- Modal to change description -->
        <div id="edit-description-modal"
            class="fixed inset-0 bg-gray-400 bg-opacity-50 justify-center items-center hidden z-50">
            <div class="bg-white rounded-lg p-6 shadow-lg max-w-lg w-full">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Edit Description</h2>

                <form action="{{ route('user.updateDescription') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <textarea name="description" label="Description"
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
                            class="px-6 py-2 rounded-md text-white border border-gray-300 bg-[#135d3b] hover:bg-[#135d3b]/85 focus:ring-2 focus:ring-gray-300 transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Account --}}
    <x-toast.confirm :buttonText="'Delete Account'" :route="'user.deleteUser'" :method="'DELETE'" :id="auth()->user()->id" :modalTitle="'Delete Account'"
        :modalMessage="'Are you sure you want to delete your account? This action is irreversible.'" :object="auth()->user()"
        class="flex items-center justify-center py-1 px-3 text-red-500 bg-white border border-red-500 hover:bg-red-500/15 
            rounded-lg active:scale-95 transition-all duration-150 ease-out w-min sm:w-auto mt-10 text-nowrap" />
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


    document.getElementById('file').addEventListener('change', function(event) {
        const maxSizeInBytes = 1024 * 1024 * 2;
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
            errorContainer.textContent =
                'One or more files exceed the 2MB size limit. Please select smaller files.';
            errorContainer.classList.remove('hidden');
            event.target.value = '';
        } else {
            errorContainer.classList.add('hidden');
        }
    });

    document.getElementById('changeProfilePicBtn').addEventListener('click', function() {
        const form = document.getElementById('profilePicForm');
        form.hidden = !form.hidden;

    });
</script>
