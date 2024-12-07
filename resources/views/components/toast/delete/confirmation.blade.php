<div>
  <!-- Button to trigger confirmation -->
  <div>
    <button id="confirmationButton" class="px-4 py-2 bg-blue-500 text-white rounded">
      {{$buttonName}}
    </button>
  </div>


  <div id="confirmationModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
      <h2 class="text-lg font-bold text-gray-900 mb-4">Are you sure?</h2>
      <p class="text-sm text-gray-600 mb-6">This action cannot be undone.</p>

      <!-- Form action dynamically set based on the buttonName -->
      <form id="confirmationForm" action="{{$action}}" method="GET" class="w-full">
        @csrf

        <div class="flex justify-end space-x-4">
          <button type="button" id="cancelButton" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
            Cancel
          </button>
          <button type="submit" class="px-4 py-2 rounded text-white" style="background-color: #135d3b; hover:bg-opacity-80;">
            Confirm
          </button>
        </div>
      </form>
    </div>
  </div>

</div>

<script>
  const confirmationButton = document.getElementById('confirmationButton');
  const confirmationModal = document.getElementById('confirmationModal');
  const cancelButton = document.getElementById('cancelButton');
  const confirmButton = document.getElementById('confirmButton');

  // Show the modal
  confirmationButton.addEventListener('click', (e) => {
    e.preventDefault(); // Prevent default behavior
    confirmationModal.classList.remove('hidden');
  });

  // Hide the modal on cancel
  cancelButton.addEventListener('click', () => {
    confirmationModal.classList.add('hidden');
  });

  // Handle confirm action
  confirmButton.addEventListener('click', () => {
    confirmationModal.classList.add('hidden');
    // Perform the action here, such as submitting a form or sending a request
    alert('Action confirmed!');
  });
</script>
