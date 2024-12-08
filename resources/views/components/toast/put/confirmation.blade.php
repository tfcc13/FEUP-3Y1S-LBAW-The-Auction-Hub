<div>
  <!-- Button to trigger confirmation -->
  <div>
    <button id="{{ 'confirmationButton' . $idName }}" class="px-4 py-2 text-white rounded" style="background-color: #135d3b; hover:bg-opacity-80;">
      {{$buttonName}}
    </button>
  </div>


  <div id="{{ 'confirmationModal' . $idName }}" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
      <h2 class="text-lg font-bold text-gray-900 mb-4">Are you sure?</h2>
      <p class="text-sm text-gray-600 mb-6">This action cannot be undone.</p>

      <form action="{{ route($route, ['id' => $object->id]) }}" method="POST" class="w-full">
        @csrf

        <input type="hidden" name="_method" value="PUT">
        <div class="flex justify-end space-x-4">
          <button type="button" id="{{ 'cancelButton' . $idName }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
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
  document.addEventListener('DOMContentLoaded', () => {
    const confirmationButton = document.getElementById("{{ 'confirmationButton' . $idName }}");
    const confirmationModal = document.getElementById("{{ 'confirmationModal' . $idName }}");
    const cancelButton = document.getElementById("{{ 'cancelButton' . $idName }}");

    if (confirmationButton && confirmationModal && cancelButton) {
      // Show the modal
      confirmationButton.addEventListener('click', (e) => {
        e.preventDefault();
        confirmationModal.classList.remove('hidden');
      });

      // Hide the modal on cancel
      cancelButton.addEventListener('click', () => {
        confirmationModal.classList.add('hidden');
      });
    } else {
      console.error("Could not find elements for modal interaction.");
    }
  });
</script>
