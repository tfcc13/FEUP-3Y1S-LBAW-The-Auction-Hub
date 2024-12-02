@extends('layouts.auth')

@section('content')
    <div class="max-w-md mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Register</h2>
        
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    @if ($errors->has('name'))
                        <span class="text-red-500 text-xs mt-1">
                            {{ $errors->first('name') }}
                        </span>
                    @endif
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    @if ($errors->has('username'))
                        <span class="text-red-500 text-xs mt-1">
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">E-Mail Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    @if ($errors->has('email'))
                        <span class="text-red-500 text-xs mt-1">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>

                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">Birth Date</label>
                    <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    @if ($errors->has('birth_date'))
                        <span class="text-red-500 text-xs mt-1">
                            {{ $errors->first('birth_date') }}
                        </span>
                    @endif
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                    @if ($errors->has('password'))
                        <span class="text-red-500 text-xs mt-1">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>

                <div>
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                </div>

                <div class="flex flex-col space-y-3">
                    <button type="submit"
                        class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#135d3b] hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Register
                    </button>
                    <a href="{{ route('login') }}"
                        class="w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-green-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-center">
                        Login
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
