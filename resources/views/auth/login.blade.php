@extends('layouts.auth')

@section('content')
<form method="POST"
  class="flex flex-col w-full sm:w-4/5 md:w-3/5 mt-8 mx-auto bg-gray-400 p-5 rounded-md"
  action="{{ route('login') }}">
  {{ csrf_field() }}

  <label for="email" class="text-sm sm:text-base">E-mail</label>
  <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
    class="py-2 px-4 border border-gray-300 sm:border-transparent shadow-sm text-sm sm:text-base rounded-md text-black focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none">
  @if ($errors->has('email'))
  <span class="error text-red-500 text-xs sm:text-sm">
    {{ $errors->first('email') }}
  </span>
  @endif

  <label for="password" class="mt-4 text-sm sm:text-base">Password</label>
  <input id="password" type="password" name="password" required
    class="py-2 px-4 border border-gray-300 sm:border-transparent shadow-sm text-sm sm:text-base rounded-md text-black focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none">
  @if ($errors->has('password'))
  <span class="error text-red-500 text-xs sm:text-sm">
    {{ $errors->first('password') }}
  </span>
  @endif

  <label class="mt-4 text-sm sm:text-base">
    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
  </label>

  <section class="mt-6">
    <button type="submit"
      class="py-2 px-4 border border-transparent shadow-sm text-sm sm:text-base rounded-md text-white bg-[#135d3b] hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
      Login
    </button>
    <a href="{{ route('register') }}"
      class="
        block
        w-20 sm:w-auto  
        sm:inline-block
        mt-3 
        w-fir
        text-center text-green-600 hover:text-white 
        bg-white hover:bg-green-600 
        py-2 px-4 
        border border-gray-300 
        shadow-sm 
        text-sm sm:text-base 
        rounded-md
    ">
      Register
    </a>
    @if (session('success'))
    <p class="text-sm text-green-600 mt-4">
      {{ session('success') }}
    </p>
    @endif
  </section>
</form>
@endsection
