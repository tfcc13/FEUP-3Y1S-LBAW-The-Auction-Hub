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
                        label="Email" required autofocus class="form-input lowercase">
                    @if ($errors->has('email'))
                        <span class="text-red-500 pl-1">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>

                <div class="flex flex-col justify-start space-y-1 w-full">
                    <input id="password" type="password" name="password" placeholder="Password" required label="Password"
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

                @if (session('success'))
                    <p class="text-sm text-green-600 mt-4">
                        {{ session('success') }}
                    </p>
                @endif
            </div>
        </form>

        <div class="h-1"></div>
        <hr class="custom-hr w-full" />
        <div class="h-1"></div>

        <a href="{{ route('google-auth') }}">
            <button
                class="flex w-full items-center justify-center bg-gray-200 text-gray-800 rounded-lg py-2 active:scale-95 hover:bg-gray-300 transition-all duration-150 ease-out relative"
                label="Google Login">
                <svg class="absolute left-4 h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="-0.5 0 48 48"
                    version="1.1">
                    <title>Google-color</title>
                    <desc>Created with Sketch.</desc>
                    <defs> </defs>
                    <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Color-" transform="translate(-401.000000, -860.000000)">
                            <g id="Google" transform="translate(401.000000, 860.000000)">
                                <path
                                    d="M9.82727273,24 C9.82727273,22.4757333 10.0804318,21.0144 10.5322727,19.6437333 L2.62345455,13.6042667 C1.08206818,16.7338667 0.213636364,20.2602667 0.213636364,24 C0.213636364,27.7365333 1.081,31.2608 2.62025,34.3882667 L10.5247955,28.3370667 C10.0772273,26.9728 9.82727273,25.5168 9.82727273,24"
                                    id="Fill-1" fill="#FBBC05"> </path>
                                <path
                                    d="M23.7136364,10.1333333 C27.025,10.1333333 30.0159091,11.3066667 32.3659091,13.2266667 L39.2022727,6.4 C35.0363636,2.77333333 29.6954545,0.533333333 23.7136364,0.533333333 C14.4268636,0.533333333 6.44540909,5.84426667 2.62345455,13.6042667 L10.5322727,19.6437333 C12.3545909,14.112 17.5491591,10.1333333 23.7136364,10.1333333"
                                    id="Fill-2" fill="#EB4335"> </path>
                                <path
                                    d="M23.7136364,37.8666667 C17.5491591,37.8666667 12.3545909,33.888 10.5322727,28.3562667 L2.62345455,34.3946667 C6.44540909,42.1557333 14.4268636,47.4666667 23.7136364,47.4666667 C29.4455,47.4666667 34.9177955,45.4314667 39.0249545,41.6181333 L31.5177727,35.8144 C29.3995682,37.1488 26.7323182,37.8666667 23.7136364,37.8666667"
                                    id="Fill-3" fill="#34A853"> </path>
                                <path
                                    d="M46.1454545,24 C46.1454545,22.6133333 45.9318182,21.12 45.6113636,19.7333333 L23.7136364,19.7333333 L23.7136364,28.8 L36.3181818,28.8 C35.6879545,31.8912 33.9724545,34.2677333 31.5177727,35.8144 L39.0249545,41.6181333 C43.3393409,37.6138667 46.1454545,31.6490667 46.1454545,24"
                                    id="Fill-4" fill="#4285F4"> </path>
                            </g>
                        </g>
                    </g>
                </svg>
                Google
            </button>
            <!-- Error Message -->
            @if ($errors->has('google'))
                <div class="mt-2 text-sm text-red-600">
                    {{ $errors->first('google') }}
                </div>
            @endif
        </a>

        <div class="flex justify-center space-x-1">
            <span class="text-gray-500 space-x-1">Don't have an account?</span>
            <a href="{{ route('register') }}" class="hover:underline text-gray-800">Register here.</a>
        </div>
    </div>

    <style>
        .custom-hr {
            border: none;
            border-top: 2px solid;
            color: #e5e7eb;
            overflow: visible;
            text-align: center;
            height: 5px;
            position: relative;
        }

        .custom-hr::after {
            background: #fff;
            content: 'ou continua com';
            padding: 0 10px;
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            color: #6b7280;
        }
    </style>
@endsection
