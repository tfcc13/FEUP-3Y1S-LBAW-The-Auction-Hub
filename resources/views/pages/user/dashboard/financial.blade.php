@extends('layouts.user.dashboard')

@section('inner_content')
    <div class="flex flex-col space-y-6 w-full" id="financial-content">
        <h3 class="text-2xl font-semibold text-gray-800">Your Finances</h3>

        {{-- Current Balance --}}
        <div class="flex flex-col sm:flex-row items-baseline space-x-8">
            <span class="text-gray-600 text-lg font-medium">Current Balance: </span>
            <span id="balance-display" class="text-gray-800 text-lg font-semibold">
                ${{ number_format(auth()->user()->credit_balance, 2, '.', ' ') }}
            </span>
        </div>

        {{-- Deposit Form --}}
        <form id="deposit-form" action="/user/{{ auth()->user()->id }}/deposit-money" method="POST" class="flex flex-col space-y-4 w-min">
            @csrf
            <input type="hidden" id="user-id" value="{{ auth()->user()->id }}">

            <div id="deposit-section" class="flex flex-col space-y-4 w-min">
                <input id="deposit-amount" type="number" name="amount" min="1" placeholder="Enter amount" required autofocus class="form-input">
                <input id="deposit-reference" type="text" name="reference" placeholder="Enter reference" required class="form-input">
                <button type="submit" id="deposit-button" class="bg-[#135d3b] text-white rounded-lg py-2 active:scale-95 hover:bg-[#135d3b]/85 transition-all duration-150 ease-out">
                    Deposit
                </button>
                <p id="deposit-error-message" class="text-red-500 text-sm hidden">Deposit amount cannot exceed $100,000</p>
             </div>
        </form>

        {{-- Withdraw Form --}}
        <form id="withdraw-form" action="/user/{{ auth()->user()->id }}/withdraw-money" method="POST" class="flex flex-col space-y-4 w-min">
            @csrf
            <input type="hidden" id="user-id" value="{{ auth()->user()->id }}">

            <div id="withdraw-section" class="flex flex-col space-y-4 w-min">
                <input id="withdraw-amount" type="number" name="amount" min="1" placeholder="Enter amount" required class="form-input">
                <div id="iban-container">
                    <input id="iban" type="text" name="iban" placeholder="Enter IBAN" class="form-input" pattern="^[A-Za-z]{2}\d{21}$" title="IBAN should be two letters followed by 21 digits" required>
                    <p id="iban-error-message" class="text-red-500 text-sm hidden">IBAN is invalid.</p>
                </div>
                <button type="submit" id="withdraw-button" class="bg-[#b1353b] text-white rounded-lg py-2 active:scale-95 hover:bg-[#b1353b]/85 transition-all duration-150 ease-out">
                    Withdraw
                </button>
                <p id="withdraw-error-message" class="text-red-500 text-sm hidden">Withdraw amount cannot exceed $100,000</p>
            </div>
        </form>

       

        {{-- Message --}}
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
        
        let operationType = '';

        // Handle Deposit Form Submit
        document.getElementById('deposit-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const referenceField = document.getElementById('deposit-reference').value;
            formData.append('operationType', 'Deposit');
            formData.append('reference', referenceField);
            const messageElement = document.getElementById('message');
            const balanceDisplay = document.getElementById('balance-display');
            const userId = document.getElementById('user-id').value;
            const depositAmount = parseFloat(document.getElementById('deposit-amount').value);

            if (!checkAmountLimit(depositAmount, 'Deposit')) {
                return;  
            }

            // Fetch URL for Deposit
            const url = '/user/' + userId + '/deposit-money';

            fetch(url, {
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
                    form.reset();
                }
            })
            .catch(error => {
                messageElement.textContent = 'An error occurred. Please try again.';
                messageElement.style.color = 'red';
                console.error('Error:', error);
            });
        });

        // Handle Withdraw Form Submit
        document.getElementById('withdraw-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            formData.append('operationType', 'Withdraw');
            const messageElement = document.getElementById('message');
            const balanceDisplay = document.getElementById('balance-display');
            const userId = document.getElementById('user-id').value;
            const amount = parseFloat(document.getElementById('withdraw-amount').value);

            if (!checkAmountLimit(amount, 'Withdraw')) {
                return;  
            }

            // Fetch URL for Withdraw
            const url = '/user/' + userId + '/withdraw-money';

            fetch(url, {
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
                    form.reset();
                }
            })
            .catch(error => {
                messageElement.textContent = 'An error occurred. Please try again.';
                messageElement.style.color = 'red';
                console.error('Error:', error);
            });
        });



        // Helper function to format numbers like PHP's number_format
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ' ' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }


        document.getElementById('iban').addEventListener('input', function() {
            const ibanValue = this.value;
            const withdrawButton = document.getElementById('withdraw-button');
            const ibanPattern = /^[A-Za-z]{2}\d{21}$/;
            const ibanErrorMessage = document.getElementById('iban-error-message');

            if (ibanPattern.test(ibanValue)) {
                withdrawButton.disabled = false; 
                ibanErrorMessage.classList.add('hidden'); // Hide error message
            } else {
                withdrawButton.disabled = true; 
                ibanErrorMessage.classList.remove('hidden'); // Show error message
            }
        });

        function checkAmountLimit(amount, operationType) {

            let current = 'withdraw';

            if(operationType === 'Deposit' ){
                current = 'deposit';
            }


            const errorMessageElement = document.getElementById(current+'-error-message');

           
            if (amount > 100000) {
                errorMessageElement.classList.remove('hidden');
                
                setTimeout(() => {
                    errorMessageElement.classList.add('hidden');
                }, 3000);
                
                return false;  
            } else {
                errorMessageElement.classList.add('hidden');
                return true; 
            }
}
    </script>
@endsection
