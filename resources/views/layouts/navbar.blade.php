<nav class="bg-[#135d3b]">
  <div class="w-full flex flex-wrap items-center justify-between p-4 ml-0 mr-0">
    <a href="{{ url('/home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">The Auction Hub</span>
    </a>
    <button data-collapse-toggle="navbar-default" type="button" class="bg-[#0ff290] inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
      <span class="sr-only">Open main menu</span>
      <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
      </svg>
    </button>
    <div class="sd:w-full md:w-1/4 lg:w-1/4 mx-2 hidden md:block">
      <form action="{{ url('/auctions/search') }}" method="GET">
        <input
          type="text"
          id="search-navbar"
          name="search"
          class="block w-full pt-9 px-4 text-3xl md:mt-6 md:mb-0 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          placeholder="Search...">
      </form>
    </div>
    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
      <ul class="font-medium flex flex-col p-4 md:p-0 sm:mr-8 mt-4 md:flex-row md:space-x-8 rtl:space-x-reverse">
        <li class="flex items-center justify-center">
          <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Live Auctions</a>
        </li>
        <li class="flex items-center justify-center">
          <a href="#" class=" block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">My Auctions</a>
        </li>
        <li class="flex items-center justify-center">
          <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Following</a>
        </li>
        <li>

          @if (Auth::check())
          <a href="{{ url('/dashboard') }}"><x-user.image></x-user></a>
          @else
          <a class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent" href="{{ url('/login') }}"> Login </a>
          @endif

        </li>
      </ul>
    </div>
  </div>
  <div class="sd:w-full md:w-1/4 lg:w-1/4 mx-2 md:hidden">
    <form action="{{ url('/auctions/search') }}" method="GET">
      <input
        type="text"
        id="search-navbar"
        name="search"
        class="block w-full pt-9 px-4 text-3xl md:mt-6 md:mb-0 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="Search...">
    </form>
  </div>
</nav>
