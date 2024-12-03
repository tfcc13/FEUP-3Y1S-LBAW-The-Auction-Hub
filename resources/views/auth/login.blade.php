@extends('layouts.auth')

@section('content')
    <div class="flex flex-col max-w-md mx-auto space-y-5">
        <span class="text-2xl font-semibold text-gray-800 text-center">Login</span>

        <span class="text-gray-600 text-center">Welcome back to your auction hub</span>

        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="flex flex-col justify-start space-y-4 w-full">
                <div class="flex flex-col justify-start space-y-1 w-full">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                        required autofocus class="form-input lowercase">
                    @if ($errors->has('email'))
                        <span class="text-red-500 pl-1">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-col justify-start space-y-1 w-full">
                    <input id="password" type="password" name="password" placeholder="Password" required
                        class="form-input">
                    @if ($errors->has('password'))
                        <span class="text-red-500 text-xs mt-1">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Remember Me</label>
                </div>


                <button type="submit"
                    class="w-full bg-[#135d3b] text-white rounded-lg py-2 active:scale-95 hover:bg-[#135d3b]/85 transition-all duration-150 ease-out">
                    Login
                </button>

                <div class="flex justify-center space-x-1">
                    <span class="text-gray-500 space-x-1">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="hover:underline text-gray-800">Register here.</a>
                </div>

                @if (session('success'))
                    <p class="text-sm text-green-600 mt-4">
                        {{ session('success') }}
                    </p>
                @endif
            </div>
        </form>
    </div>
@endsection
