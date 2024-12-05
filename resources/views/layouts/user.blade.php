@extends('layouts.app')

@section('content')
<div class="p-4">
  <div class="grid grid-cols-1 md:grid-cols-6 lg:grid-cols-8 gap-6 md:h-full">
    @yield('content')
  </div>
</div>
@endsection
