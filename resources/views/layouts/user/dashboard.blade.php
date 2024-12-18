@extends('layouts.app')

@section('content')
    <div class="flex flex-col h-screen">
        <!-- Top Navigation Bar -->
        <div class="bg-white border-b">
            <nav class="container mx-auto px-6">
                <ul class="flex w-full list-none">

                    {{-- Dashboard --}}
                    <li class="w-full">
                        <a href="{{ route('dashboard') }}"
                            class="tab-link {{ request()->routeIs('dashboard') ? 'text-[#135d3b]' : 'text-gray-800' }} ">
                            <span class="material-symbols-outlined">home</span>
                            <span class="hidden sm:inline">Dashboard</span>
                            @if (request()->routeIs('dashboard'))
                                <div class="absolute bottom-0 left-0 w-full h-1 bg-[#135d3b]"></div>
                            @endif
                        </a>
                    </li>

                    {{-- Financial --}}
                    <li class="w-full">
                        <a href="{{ route('user.dash.financial') }}"
                            class="tab-link {{ request()->routeIs('user.dash.financial') ? 'text-[#135d3b]' : 'text-gray-800' }}">
                            <span class="material-symbols-outlined">payments</span>
                            <span class="hidden sm:inline">Finances</span>
                            @if (request()->routeIs('user.dash.financial'))
                                <div class="absolute bottom-0 left-0 w-full h-1 bg-[#135d3b]"></div>
                            @endif
                        </a>
                    </li>

                    {{-- My Auctions --}}
                    <li class="w-full">
                        <a href="{{ route('user.dash.auctions') }}"
                            class="tab-link {{ request()->routeIs('user.dash.auctions') ? 'text-[#135d3b]' : 'text-gray-800' }}">
                            <span class="material-symbols-outlined">warehouse</span>
                            <span class="hidden sm:inline">Auctions</span>
                            @if (request()->routeIs('user.dash.auctions'))
                                <div class="absolute bottom-0 left-0 w-full h-1 bg-[#135d3b]"></div>
                            @endif
                        </a>
                    </li>

                    {{-- Bids --}}
                    <li class="w-full">
                        <a href="{{ route('user.dash.bids') }}"
                            class="tab-link {{ request()->routeIs('user.dash.bids') ? 'text-[#135d3b]' : 'text-gray-800' }}">
                            <span class="material-symbols-outlined">gavel</span>
                            <span class="hidden sm:inline">Bids</span>
                            @if (request()->routeIs('user.dash.bids'))
                                <div class="absolute bottom-0 left-0 w-full h-1 bg-[#135d3b]"></div>
                            @endif
                        </a>
                    </li>

                    {{-- Statistics --}}
                    <li class="w-full">
                        <a href="{{ route('user.dash.stats') }}"
                            class="tab-link {{ request()->routeIs('user.dash.stats') ? 'text-[#135d3b]' : 'text-gray-800' }}">
                            <span class="material-symbols-outlined">equalizer</span>
                            <span class="hidden sm:inline">Statistics</span>
                            @if (request()->routeIs('user.dash.stats'))
                                <div class="absolute bottom-0 left-0 w-full h-1 bg-[#135d3b]"></div>
                            @endif
                        </a>
                    </li>   
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white">
            @yield('inner_content')
        </div>
    </div>
@endsection
