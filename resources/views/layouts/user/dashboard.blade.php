@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-[rgb(19,93,59)] text-white shadow-lg flex-shrink-0 overflow-y-auto">
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
        @yield('inner_content')
    </div>
</div>
@endsection
