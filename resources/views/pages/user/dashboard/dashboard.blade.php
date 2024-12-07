@extends('layouts.user.dashboard')

@section('inner_content')
<!-- Main Content -->
<div class="flex-1 p-8 bg-white">
  <h3 class="text-2xl font-semibold text-[rgb(19,93,59)]">Welcome to Your Dashboard</h3>
  <p class="mt-2 text-gray-600">Select an option from the menu to view details or perform actions.</p>
  @include('components.user.userDescription')
</div>
@endsection
