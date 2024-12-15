@props(['class' => 'px-4 py-2 text-white rounded-lg bg-[#135d3b]'])

<div>
    <!-- Trigger Button -->
    <button id="confirmationButton-{{ $id }}" class="{{ $class }}"
        data-modal-target="confirmationModal-{{ $id }}">
        {{ $buttonText }}
    </button>

    <!-- Modal -->
    <div id="confirmationModal-{{ $id }}"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-bold text-gray-900 mb-4">{{ $modalTitle }}</h2>
            <p class="text-sm text-gray-600 mb-4">{{ $modalMessage }}</p>
            <form action="{{ $object ? route($route, ['id' => $object->id]) : route($route) }}" method="POST"
                class="w-full">
                @csrf
                @if (strtoupper($method) !== 'POST')
                    @method($method)
                @endif
                @if ($textFlag)
                    <div class="mb-4">
                        <label for="text" class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea name="text" id="text"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            placeholder="Enter your message here">{{ old('text', $text) }}</textarea>
                    </div>
                @endif
                <div class="flex justify-end space-x-4">
                    <button type="button"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 cancelButton">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 rounded text-white" style="background-color: #135d3b;">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-modal-target]').forEach(button => {
            const modalId = button.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            const cancelButton = modal.querySelector('.cancelButton');

            // Show modal
            button.addEventListener('click', () => modal.classList.remove('hidden'));

            // Hide modal on cancel
            cancelButton.addEventListener('click', () => modal.classList.add('hidden'));
        });
    });
</script>
