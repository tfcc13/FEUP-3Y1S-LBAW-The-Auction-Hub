@extends('layouts.app')

@section('content')
<div class="flex h-screen">
  <!-- Sidebar -->
  <div class="w-64 bg-[rgb(19,93,59)] text-white shadow-lg flex-shrink-0 overflow-y-auto">
    <div class="p-6">
      <h4 class="text-lg font-semibold border-b border-white/50 pb-2">Admin Dashboard</h4>
    </div>
    <ul class="mt-6 space-y-2">
      <li>
        <a href="#"
          class="block px-4 py-3 hover:bg-white hover:text-[rgb(19,93,59)] rounded transition 
                              {{ request()->routeIs('admin.users') ? 'bg-white text-[rgb(19,93,59)]' : '' }}">
          👥 Manage Users
        </a>
      </li>
      <li>
        <a href="#"
          class="block px-4 py-3 hover:bg-white hover:text-[rgb(19,93,59)] rounded transition 
                              {{ request()->routeIs('admin.auctions') ? 'bg-white text-[rgb(19,93,59)]' : '' }}">
          🛒 Manage Auctions
        </a>
      </li>
      <li>
        <a href="#"
          class="block px-4 py-3 hover:bg-white hover:text-[rgb(19,93,59)] rounded transition 
                              {{ request()->routeIs('admin.analytics') ? 'bg-white text-[rgb(19,93,59)]' : '' }}">
          📈 Analytics
        </a>
      </li>
      <li>
        <a href="{{ route('admin.dashboard.categories') }}"
          class="block px-4 py-3 hover:bg-white hover:text-[rgb(19,93,59)] rounded transition 
                              {{ request()->routeIs('admin.reports') ? 'bg-white text-[rgb(19,93,59)]' : '' }}">
          🔠 Categories
        </a>
      </li>
      <li>
        <a href="#"
          class="block px-4 py-3 hover:bg-white hover:text-[rgb(19,93,59)] rounded transition 
                              {{ request()->routeIs('admin.reports') ? 'bg-white text-[rgb(19,93,59)]' : '' }}">
          📋 Reports
        </a>
      </li>
      <li>
        <a href="#"
          class="block px-4 py-3 hover:bg-white hover:text-[rgb(19,93,59)] rounded transition 
                              {{ request()->routeIs('admin.settings') ? 'bg-white text-[rgb(19,93,59)]' : '' }}">
          ⚙️ Settings
        </a>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="flex-1 p-8 bg-white">
    @yield('Display')
  </div>
</div>
@endsection
