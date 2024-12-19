@extends('layouts.user.dashboard')

@section('inner_content')

@if(session('error'))
<div class="alert alert-danger text-red-500 bg-red-100 border border-red-400 rounded p-4">
  {{ session('error') }}
</div>
@endif
<!-- Main Content -->
<div class="flex-1 bg-white">
  <h3 class="text-2xl font-semibold text-gray-800">Welcome to Your Dashboard</h3>
  <p class="mt-2 text-gray-600">Here you can manage everything related to your account.</p>
  @include('components.user.userDescription')
</div>
@endsection
