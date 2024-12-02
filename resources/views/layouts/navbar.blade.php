<nav class="bg-[#135d3b]">
    <div class="w-full flex flex-wrap items-center justify-between p-6">
        <a href="{{ url('/home') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/crown_logo.webp') }}" alt="The Auction Hub Logo" class="w-10 object-contain">
            <span class="text-xl font-semibold text-white">The Auction Hub</span>
        </a>

        <button data-collapse-toggle="navbar-default" type="button"
            class="bg-[#0ff290] inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
            aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>

        <div class="sd:w-full md:w-1/4 hidden md:flex">
            <form action="{{ url('/auctions/search') }}" method="GET" class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input id="search-navbar" type="text" name="search" placeholder="Search..."
                    class="form-input text-sm w-[25vw] !pl-10">
            </form>
        </div>

        <div class="hidden w-full md:flex md:w-auto" id="navbar-default">
            <ul class="flex flex-col md:flex-row md:space-x-4">
                @if (Auth::check())
                    <li class="flex items-center justify-center">
                        <a href="#"
                            class="px-2 py-[0.375rem] font-semibold text-white bg-[#135d3b] hover:bg-[#0f4a2f] rounded-lg w-28 text-center transition-transform hover:scale-105 active:scale-95">
                            My Auctions
                        </a>
                    </li>
                    <li class="flex items-center justify-center">
                        <a href="#"
                            class="px-2 py-[0.375rem] font-semibold text-white bg-[#135d3b] hover:bg-[#0f4a2f] rounded-lg w-28 text-center transition-transform hover:scale-105 active:scale-95">
                            Following
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard') }}"><x-user.image></x-user></a>
                    </li>
                @else
                    <li class="flex items-center justify-center">
                        <a href="{{ url('/register') }}"
                            class="px-2 py-[0.375rem] font-semibold text-[#135d3b] bg-white hover:bg-gray-100 rounded-lg w-28 text-center transition-transform hover:scale-105 active:scale-95">
                            Register
                        </a>
                    </li>
                    <li class="flex items-center justify-center">
                        <a href="{{ url('/login') }}"
                            class="px-2 py-[0.375rem] font-semibold text-white bg-[#135d3b] hover:bg-[#0f4a2f] rounded-lg w-28 text-center transition-transform hover:scale-105 active:scale-95">
                            Login
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="sd:w-full md:w-1/4 lg:w-1/4 mx-2 md:hidden">
        <form action="{{ url('/auctions/search') }}" method="GET" class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input id="search-navbar" type="text" name="search" placeholder="Search..." class="form-input pl-10">
        </form>
    </div>
</nav>
