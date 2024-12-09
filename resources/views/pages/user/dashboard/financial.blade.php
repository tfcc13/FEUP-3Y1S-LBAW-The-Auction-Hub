@extends('layouts.user.dashboard')

@section('inner_content')
    <div class="flex flex-col space-y-6 w-full" id="financial-content">
        <h3 class="text-2xl font-semibold text-gray-800">Your Auction Statistics</h3>
        <form id="add-money-form">
            @csrf
            <input type="number" name="amount" placeholder="Enter amount" min="1" required>
            <button type="submit">Add Money</button>
        </form>
        <p id="balance-info">Current Balance: ${{ auth()->user()->credit_balance }}</p>
        <p id="message"></p>
    </div>

    <!-- Full-width notification bar -->
    <div id="notification-bar"
        class="fixed top-40 left-0 right-0 transform translate-y-[-200%] transition-transform duration-300 ease-in-out z-50 opacity-0 pointer-events-none">
        <div class="bg-white text-[#135d3b] px-4 py-3 border-b-2 border-[#135d3b]">
            <div class="max-w-screen-xl mx-auto flex items-center">
                <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p id="notification-message" class="text-sm font-medium"></p>
            </div>
        </div>
    </div>

    <style>
        #financial-content {
            transition: margin-top 0.3s ease-in-out;
        }
    </style>

    <script>
        function showNotification(message, duration = 3000) {
            const bar = document.getElementById('notification-bar');
            const messageEl = document.getElementById('notification-message');
            const financialContent = document.getElementById('financial-content');
            messageEl.textContent = message;

            // Show notification
            bar.classList.remove('translate-y-[-200%]', 'opacity-0', 'pointer-events-none');
            bar.classList.add('translate-y-0', 'opacity-100');

            // Adjust financial content margin
            financialContent.style.marginTop = `${bar.offsetHeight}px`;

            // Auto hide after duration unless manually closed
            if (duration) {
                setTimeout(hideNotification, duration);
            }
        }

        function hideNotification() {
            const bar = document.getElementById('notification-bar');
            const financialContent = document.getElementById('financial-content');

            bar.classList.remove('translate-y-0', 'opacity-100');
            bar.classList.add('translate-y-[-200%]', 'opacity-0', 'pointer-events-none');

            // Reset financial content margin
            financialContent.style.marginTop = '0';
        }

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
                        showNotification(data.message);
                        balanceInfo.textContent = `Current Balance: $${data.balance}`;
                        form.reset();
                    }
                })
                .catch(error => {
                    messageElement.textContent = 'An error occurred. Please try again.';
                    messageElement.style.color = 'red';
                    console.error('Error:', error);
                });
        });
    </script>
@endsection
