@extends('layouts.app')

@section('content')
    <div class="flex flex-col h-screen">
        <!-- Top Navigation Bar -->
        <div class="bg-white border-b">
            <nav class="container mx-auto px-6">
                <ul class="flex w-full list-none">
                    {{-- Reports --}}
                    <li class="w-full">
                        <a href="{{ route('admin.dashboard') }}"
                            class="tab-link {{ request()->routeIs('admin.dashboard') ? 'text-[#135d3b]' : 'text-gray-800' }}">
                            <span class="material-symbols-outlined">lab_profile</span>
                            <span class="hidden sm:inline">Reports</span>
                            @if (request()->routeIs('admin.dashboard'))
                                <div class="absolute bottom-0 left-0 w-full h-1 bg-[#135d3b]"></div>
                            @endif
                        </a>
                    </li>

                    {{-- Manage Users --}}
                    <li class="w-full">
                        <a href="{{ route('admin.dashboard.users') }}"
                            class="tab-link {{ request()->routeIs('admin.dashboard.users') ? 'text-[#135d3b]' : 'text-gray-800' }}">
                            <span class="material-symbols-outlined">groups</span>
                            <span class="hidden sm:inline">Users</span>
                            @if (request()->routeIs('admin.dashboard.users'))
                                <div class="absolute bottom-0 left-0 w-full h-1 bg-[#135d3b]"></div>
                            @endif
                        </a>
                    </li>

                    {{-- Manage Auctions --}}
                    <li class="w-full">
                        <a href="{{ route('admin.dashboard.auctions') }}"
                            class="tab-link {{ request()->routeIs('admin.dashboard.auctions') ? 'text-[#135d3b]' : 'text-gray-800' }}">
                            <span class="material-symbols-outlined">warehouse</span>
                            <span class="hidden sm:inline">Auctions</span>
                            @if (request()->routeIs('admin.dashboard.auctions'))
                                <div class="absolute bottom-0 left-0 w-full h-1 bg-[#135d3b]"></div>
                            @endif
                        </a>
                    </li>

                    {{-- Analytics --}}
                    <li class="w-full">
                        <a href="{{ route('admin.dashboard.analytics') }}"
                            class="tab-link {{ request()->routeIs('admin.dashboard.analytics') ? 'text-[#135d3b]' : 'text-gray-800' }}">
                            <span class="material-symbols-outlined">equalizer</span>
                            <span class="hidden sm:inline">Analytics</span>
                            @if (request()->routeIs('admin.dashboard.analytics'))
                                <div class="absolute bottom-0 left-0 w-full h-1 bg-[#135d3b]"></div>
                            @endif
                        </a>
                    </li>

                    {{-- Categories --}}
                    <li class="w-full">
                        <a href="{{ route('admin.dashboard.categories') }}"
                            class="tab-link {{ request()->routeIs('admin.dashboard.categories') ? 'text-[#135d3b]' : 'text-gray-800' }}">
                            <span class="material-symbols-outlined">category</span>
                            <span class="hidden sm:inline">Categories</span>
                            @if (request()->routeIs('admin.dashboard.categories'))
                                <div class="absolute bottom-0 left-0 w-full h-1 bg-[#135d3b]"></div>
                            @endif
                        </a>
                    </li>

                    {{-- Transactions --}}
                    <li class="w-full">
                        <a href="{{ route('admin.dashboard.transactions') }}"
                            class="tab-link {{ request()->routeIs('admin.dashboard.transactions') ? 'text-[#135d3b]' : 'text-gray-800' }}">
                            <span class="material-symbols-outlined">payments</span>
                            <span class="hidden sm:inline">Transactions</span>
                            @if (request()->routeIs('admin.dashboard.transactions'))
                                <div class="absolute bottom-0 left-0 w-full h-1 bg-[#135d3b]"></div>
                            @endif
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white">
            @yield('Display')
        </div>
    </div>
@endsection
