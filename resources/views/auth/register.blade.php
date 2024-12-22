@extends('layouts.auth')

@section('content')
    <div class="flex flex-col max-w-md mx-auto space-y-5">
        <span class="text-2xl font-semibold text-gray-800 text-center">Register</span>

        <span class="text-gray-600 text-center">Create your auction hub account</span>

        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="flex flex-col justify-start space-y-4 w-full">
                <div class="flex flex-col justify-start space-y-1 w-full">
                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Name" required
                        label="Name" autofocus class="form-input">
                    @if ($errors->has('name'))
                        <span class="text-red-500 pl-1">
                            {{ $errors->first('name') }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-col justify-start space-y-1 w-full">
                    <input id="username" type="text" name="username" value="{{ old('username') }}" label="Username"
                        placeholder="Username" required class="form-input">
                    @if ($errors->has('username'))
                        <span class="text-red-500 pl-1">
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-col justify-start space-y-1 w-full">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                        required class="form-input lowercase" label="Email">
                    @if ($errors->has('email'))
                        <span class="text-red-500 pl-1">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-col justify-start space-y-1 w-full">
                    <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required
                        class="form-input" label="Birth Date">
                    @if ($errors->has('birth_date'))
                        <span class="text-red-500 pl-1">
                            {{ $errors->first('birth_date') }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-col justify-start space-y-1 w-full">
                    <input id="password" type="password" name="password" placeholder="Password" required class="form-input"
                        label="Password">
                    @if ($errors->has('password'))
                        <span class="text-red-500 pl-1">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-col justify-start space-y-1 w-full">
                    <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password"
                        required class="form-input" label="Confirm Password">
                </div>

                <button type="submit"
                    class="w-full bg-[#135d3b] text-white rounded-lg py-2 active:scale-95 hover:bg-[#135d3b]/85 transition-all duration-150 ease-out">
                    Register
                </button>

                <div class="flex justify-center space-x-1">
                    <span class="text-gray-500">Already have an account?</span>
                    <a href="{{ route('login') }}" class="hover:underline text-gray-800">Login here.</a>
                </div>
            </div>
        </form>
    </div>
@endsection
