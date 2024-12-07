@extends('layouts.user.dashboard')

@section('inner_content')
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
@endsection
