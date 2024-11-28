
@extends('layouts.app')

@section('content')
<div class="p-4">
  <div class="grid grid-cols-1 md:grid-cols-6 lg:grid-cols-8 gap-6 md:h-full">
    <!-- Left Side -->
    <div class="md:col-start-2 border border-gray-700 rounded shadow lg:col-start-2 md:col-span-2 lg:col-span-2 md:h-full">
      @yield('left')
    </div>

    <!-- Right Side -->
    <div class="md:col-span-3 lg:col-span-4 border dark:border-gray-700">
      @yield('right')
    </div>
  </div>
</div>
@endsection
