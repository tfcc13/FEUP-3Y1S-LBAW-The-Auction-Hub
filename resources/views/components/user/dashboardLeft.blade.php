<div class="w-full p-4 md:p-6">
  <!-- User Profile Picture -->
  <div class="flex items-center justify-center h-48 mb-4 rounded overflow-hidden">
    <div class="w-48 h-48">
      <x-user.image class="h-full w-full object-fill rounded"></x-user>
    </div>
  </div>
</div>

<div class="lg:m-5">
  <!-- User Details -->
  <div class="text-md font-bold text-gray-900 mb-2 sm:text-lg md:text-xl">
    <span class="mr-2">Name:</span>
    <span class="break-words">{{ auth()->user()->name }}</span>
  </div>

  <div class="text-md text-gray-500 font-bold mb-2 sm:text-lg md:text-xl">
    <span class="mr-2">Username:</span>
    <span class="break-words">{{ auth()->user()->username }}</span>
  </div>

  <div class="text-md text-gray-500 mb-4 sm:text-lg md:text-xl">
    <span class="mr-2 font-bold">Email:</span>
    <span class="break-words">{{ auth()->user()->email }}</span>
  </div>

  <!-- User Rating -->
  <div class="flex items-center text-gray-900 mb-4 sm:text-lg md:text-xl">
    <span class="mr-2 font-bold">Rating:</span>
    <div class="flex items-center">
      <!-- Generate stars dynamically -->
      @php
      $rating = auth()->user()->rating ?? 0;
      $fullStars = floor($rating);
      $hasHalfStar = $rating - $fullStars >= 0.5;
      $emptyStars = 5 - ceil($rating);
      @endphp

      @for ($i = 0; $i < $fullStars; $i++)
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24" stroke="none">
        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
        </svg>
        @endfor

        @if ($hasHalfStar)
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24" stroke="none">
          <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
        </svg>
        @endif

        @for ($i = 0; $i < $emptyStars; $i++)
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
          </svg>
          @endfor
    </div>
  </div>

  <!-- User Description -->
  <div>
    <span class="text-md">
      Description:
    </span>
    <p>{{ auth()->user()->description ?? 'No description set' }}</p> <!-- Display default text if no description -->

    <!-- Button to trigger the edit modal or form -->
    <button
      class="px-3 py-2 rounded-md border border-gray-300 bg-[#135d3b] focus:ring-2 focus:ring-gray-300"
      data-modal-toggle="edit-description-modal">
      Change Description
    </button>

    <!-- Modal to change description -->
    <div id="edit-description-modal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden z-50">
      <div class="bg-white rounded-lg p-6 shadow-lg max-w-lg w-full">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Edit Description</h2>

        <!-- Form to update description -->
        <form action="{{ route('user.updateDescription') }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-4">
            <textarea name="description" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4">{{ auth()->user()->description ?? '' }}</textarea>
          </div>

          <div class="flex justify-end space-x-4">
            <button type="submit" class=" px-6 py-2 rounded-md border border-gray-300 bg-[#135d3b] focus:ring-2 focus:ring-gray-300">
              Save Changes
            </button>
            <button
              type="button"
              class=" px-6 py-2 rounded-md border border-gray-300 bg-[#135d3b] focus:ring-2 focus:ring-gray-300"
              onclick="document.getElementById('edit-description-modal').classList.add('hidden')">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <form id="add-money-form">
    @csrf
    <input type="number" name="amount" placeholder="Enter amount" min="1" required>
    <button type="submit">Add Money</button>
  </form>
  <p id="balance-info">Current Balance: ${{ auth()->user()->credit_balance }}</p>
  <p id="message"></p>

  <!-- Success Message -->
  @if (session('success'))
  <div class="p-4 mb-4 text-green-800 bg-green-200 rounded-md">
    {{ session('success') }}
  </div>
  @endif

  <script>
    function toggleModal(show) {
      const modal = document.getElementById('edit-description-modal');
      if (show) {
        modal.classList.remove('hidden');
      } else {
        modal.classList.add('hidden');
      }
    }

    // Add event listener to the button
    document.querySelector('[data-modal-toggle="edit-description-modal"]').addEventListener('click', () => {
      toggleModal(true);
    });


    document.getElementById('add-money-form').addEventListener('submit', function(e) {
      e.preventDefault();

      const form = e.target;
      const formData = new FormData(form);
      const messageElement = document.getElementById('message');
      const balanceInfo = document.getElementById('balance-info');

      fetch('/user/add-money', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: formData,
        })
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            messageElement.textContent = data.error;
            messageElement.style.color = 'red';
          } else {
            messageElement.textContent = data.message;
            messageElement.style.color = 'green';
            balanceInfo.textContent = `Current Balance: $${data.balance}`;
          }
        })
        .catch(error => {
          messageElement.textContent = 'An error occurred. Please try again.';
          messageElement.style.color = 'red';
          console.error('Error:', error);
        });
    });
  </script>
</div>
