@extends('layouts.admin.dashboard')

@section('Display')
<!-- Main Content -->
<div class="flex-1 p-8 bg-white">
  <h3 class="text-2xl font-semibold text-[rgb(19,93,59)]">Welcome to Your Dashboard</h3>
  <p class="mt-2 text-gray-600">Select an option from the menu to view details or perform actions.</p>

  <!-- Reports Section -->
  <div class="mt-8">
    <h4 class="text-xl font-semibold text-gray-800">Your Reports</h4>
    <ul class="mt-4 space-y-2">
      @forelse ($categories as $category)
      <li class="p-4 border border-gray-200 rounded shadow-sm">
        <p class="font-medium text-gray-700">Category Name: {{ $category->name }}</p>
      </li>
      @empty
      <li class="text-gray-500">You have no reports.</li>
      @endforelse
    </ul>
  </div>
</div>
@endsection
