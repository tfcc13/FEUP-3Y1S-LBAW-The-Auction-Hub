@extends('layouts.auth')

@section('content')
<form method="POST"
  class="flex flex-col w-full sm:w-4/5 md:w-3/5 mt-8 mx-auto bg-gray-400 p-5 rounded-md"
  action="{{ route('register') }}">
  {{ csrf_field() }}

  <label for="name">Name</label>
  <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
    class="py-2 px-4 border border-gray-300 sm:border-transparent shadow-sm text-sm sm:text-base rounded-md text-black focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none">
  
  @if ($errors->has('name'))
  <span class="error">
    {{ $errors->first('name') }}
  </span>
  @endif

  <label for="username">User Name</label>
  <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
    class="py-2 px-4 border border-gray-300 sm:border-transparent shadow-sm text-sm sm:text-base rounded-md text-black focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none">
  
  @if ($errors->has('username'))
  <span class="error">
    {{ $errors->first('username') }}
  </span>
  @endif

  <label for="email">E-Mail Address</label>
  <input id="email" type="email" name="email" value="{{ old('email') }}" required
    class="py-2 px-4 border border-gray-300 sm:border-transparent shadow-sm text-sm sm:text-base rounded-md text-black focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none">
  
  @if ($errors->has('email'))
  <span class="error">
    {{ $errors->first('email') }}
  </span>
  @endif

  <label for="birth_date">Birth Date</label>
  <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required autofocus
    class="py-2 px-4 border border-gray-300 sm:border-transparent shadow-sm text-sm sm:text-base rounded-md text-black focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none">
  
  @if ($errors->has('birth_date'))
  <span class="error">
    {{ $errors->first('birth_date') }}
  </span>
  @endif

  <label for="password">Password</label>
  <input id="password" type="password" name="password" required
    class="py-2 px-4 border border-gray-300 sm:border-transparent shadow-sm text-sm sm:text-base rounded-md text-black focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none">
  
  @if ($errors->has('password'))
  <span class="error">
    {{ $errors->first('password') }}
  </span>
  @endif

  <label for="password-confirm">Confirm Password</label>
  <input id="password-confirm" type="password" name="password_confirmation" required
    class="py-2 px-4 border border-gray-300 sm:border-transparent shadow-sm text-sm sm:text-base rounded-md text-black focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none">
  
<section class="mt-6">
    <button type="submit"
      class="py-2 px-4 border border-transparent shadow-sm text-sm sm:text-base rounded-md text-white bg-[#135d3b] hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
    
    Register
  </button>
    <a href="{{ route('login') }}"
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
    Login</a>
</section>
</form>
@endsection
