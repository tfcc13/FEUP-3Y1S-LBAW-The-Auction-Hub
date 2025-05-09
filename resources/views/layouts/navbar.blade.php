<nav class="bg-[#135d3b] w-full flex items-center justify-between p-6">

    <a href="{{ url('/home') }}" class="flex items-center space-x-2">
        <img src="{{ asset('images/crown_logo.webp') }}" alt="The Auction Hub Logo" class="w-10 object-contain">
        <span class="hidden sm:block text-xl font-semibold text-white text-nowrap">The Auction Hub</span>
    </a>

    <div class="flex w-1/2 md:w-1/4">
        <form action="{{ url('/search') }}" method="GET" class="relative w-full m-0">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input id="search-navbar" type="text" name="search" placeholder="Search..."
                class="form-input text-sm w-full !pl-10" label="Search">
        </form>
    </div>


    <ul class="flex w-auto items-center space-x-4" id="navbar-default">
        @if (Auth::check())
            @if (!Auth::user()->is_admin)
                {{-- Create Auction --}}
                <li class="hidden md:flex items-center justify-center">
                    <a href="/auctions/create_auction"
                        class="px-2 py-[0.375rem] font-semibold text-[#135d3b] bg-white hover:bg-gray-300 rounded-lg w-36 
                            text-center transition-all active:scale-95">
                        Create Auction
                    </a>
                </li>

                {{-- Following --}}
                <li class="hidden md:flex items-center justify-center">
                    <a href="/user/follow"
                        class="px-2 py-[0.375rem] font-semibold text-white bg-[#135d3b] hover:bg-[#0f4a2f] rounded-lg w-36 
                            text-center transition-all active:scale-95">
                        Following
                    </a>
                </li>

                {{-- Notifications --}}
                <li class="hidden md:flex items-center justify-center">
                    <a href="{{ route('notifications.index') }}"
                        class="flex p-2 font-semibold text-white bg-[#135d3b] hover:bg-[#0f4a2f] rounded-full items-center justify-center transition-all active:scale-95">
                        <span class="material-symbols-outlined" style="font-size: 1.5rem;">
                            notifications
                        </span>
                    </a>
                </li>
            @endif

            <li class="flex items-center justify-center list-none">
                <x-popup.popup position="bottom-left" width="w-52">
                    <x-slot:trigger>
                        <button onclick="togglePopup(this)"
                            class="flex w-10 h-10 rounded-full overflow-hidden transition-all duration-150 active:scale-95 
                                    hover:shadow-lg focus:outline-none">
                            <x-user.image class="w-full h-full object-cover" />
                        </button>
                    </x-slot:trigger>

                    <x-slot:content>
                        <div class="space-y-2 md:-mt-2">
                            {{-- Mobile Navigation --}}
                            @if (!Auth::user()->is_admin)
                                <a href="/auctions/create_auction"
                                    class="md:hidden flex items-center space-x-2 py-2 px-4 text-gray-800 hover:bg-[#135d3b]/15 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    <span>Create Auction</span>
                                </a>
                                <a href="/user/follow"
                                    class="md:hidden flex items-center space-x-2 py-2 px-4 text-gray-800 hover:bg-[#135d3b]/15 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                    <span>Following</span>
                                </a>
                                <a href="{{ route('notifications.index') }}"
                                    class="md:hidden flex items-center space-x-2 -ml-[0.10rem] py-2 px-4 text-gray-800 hover:bg-[#135d3b]/15 rounded-lg">
                                    <span class="material-symbols-outlined" style="font-size: 1.5rem;">
                                        notifications
                                    </span>
                                    <span>Notifications</span>
                                </a>
                                {{-- Mobile Navigation --}}

                                <a href="{{ route('user.dashboard') }}"
                                    class="flex items-center space-x-2 py-2 px-4 text-gray-800 hover:bg-[#135d3b]/15 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <span>Profile</span>
                                </a>
                            @else
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center space-x-2 py-2 mt-2 px-4 text-gray-800 hover:bg-[#135d3b]/15 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                            @endif

                            <a href="{{ url('logout') }}"
                                class="flex items-center space-x-2 py-2 px-4 text-gray-800 hover:bg-[#135d3b]/15 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12">
                                    </line>
                                </svg>
                                <span>Logout</span>
                            </a>
                        </div>
                    </x-slot:content>
                </x-popup.popup>
            </li>
        @else
            <li class="hidden md:flex items-center justify-center">
                <a href="{{ url('/register') }}"
                    class="px-2 py-[0.375rem] font-semibold text-[#135d3b] bg-white hover:bg-gray-300 rounded-lg w-32 
                            text-center transition-all active:scale-95">
                    Register
                </a>
            </li>
            <li class="flex items-center justify-center">
                <a href="{{ url('/login') }}"
                    class="px-2 py-[0.375rem] font-semibold text-white bg-[#135d3b] hover:bg-[#0f4a2f] rounded-lg w-auto sm:w-32 
                            text-center transition-all active:scale-95">
                    Login
                </a>
            </li>
        @endif
    </ul>
</nav>
