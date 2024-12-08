@extends('layouts.admin.dashboard')

@section('adminStats')
<!-- Main Content -->
<div class="flex-1 p-8 bg-white">
  <h3 class="text-2xl font-semibold text-[rgb(19,93,59)]">Welcome to Your Dashboard</h3>
  <p class="mt-2 text-gray-600">Select an option from the menu to view details or perform actions.</p>

  <!-- Notifications Section -->
  <div class="mt-8">
    <h4 class="text-xl font-semibold text-gray-800">Your Notifications</h4>
    <ul class="mt-4 space-y-2">
      @forelse ($notifications as $notification)
        <li class="p-4 border border-gray-200 rounded shadow-sm">
          <p class="font-medium text-gray-700">{{ $notification->title }}</p>
          <p class="text-sm text-gray-500">{{ $notification->message }}</p>
          <p class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
        </li>
      @empty
        <li class="text-gray-500">You have no notifications.</li>
      @endforelse
    </ul>
  </div>
</div>
@endsection
