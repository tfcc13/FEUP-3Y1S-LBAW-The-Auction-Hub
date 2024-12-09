@extends('layouts.user.dashboard')

@section('inner_content')
    <!-- Main Content -->
    <div class="flex-1 bg-white">
        <h3 class="text-2xl font-semibold text-[rgb(19,93,59)]">Welcome to Your Dashboard</h3>
        <p class="mt-2 text-gray-600">Here you can manage everything related to your account.</p>
        @include('components.user.userDescription')
    </div>
@endsection
