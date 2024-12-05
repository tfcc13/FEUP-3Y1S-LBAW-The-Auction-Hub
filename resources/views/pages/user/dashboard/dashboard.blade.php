@extends('layouts.user')

@section('content')
<div class="flex h-screen bg-gray-100">
  <!-- Left Sidebar -->
  <div class="w-64 bg-[rgb(19,93,59)] text-white shadow-lg flex-shrink-0">
    <div class="p-6">
      <h4 class="text-lg font-semibold border-b border-white/50 pb-2">User Dashboard</h4>
    </div>
    <ul class="mt-6 space-y-2">
      <li>
        <a href="{{ route('user.dash.stats') }}"
          class="block px-4 py-3 hover:bg-white hover:text-[rgb(19,93,59)] rounded transition 
                          {{ request()->routeIs('user.dash.stats') ? 'bg-white text-[rgb(19,93,59)]' : '' }}">
          📊 Statistics
        </a>
      </li>
      <li>
        <a href="{{ route('user.dash.financial') }}"
          class="block px-4 py-3 hover:bg-white hover:text-[rgb(19,93,59)] rounded transition 
                          {{ request()->routeIs('user.dash.financial') ? 'bg-white text-[rgb(19,93,59)]' : '' }}">
          💰 Financial
        </a>
      </li>
      <li>
        <a href="{{ route('user.dash.bids') }}"
          class="block px-4 py-3 hover:bg-white hover:text-[rgb(19,93,59)] rounded transition 
                          {{ request()->routeIs('user.dash.bids') ? 'bg-white text-[rgb(19,93,59)]' : '' }}">
          🔨 Bids
        </a>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="flex-1 p-8 bg-white">
    <h3 class="text-2xl font-semibold text-[rgb(19,93,59)]">Welcome to Your Dashboard</h3>
    <p class="mt-2 text-gray-600">Select an option from the menu to view details or perform actions.</p>
    @include('components.user.userDescription')
  </div>
</div>
@endsection
