<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Klosz') }}</title>
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('storage/logo/klosz_logo.png') }}">
</head>
<body class=" h-screen antialiased leading-none">
<div id="app">
    <nav class="bg-indigo-500 shadow mb-4 py-2">
        <div class="container mx-auto px-6 md:px-0">
            <div class="flex items-center justify-between text-yellow-500">
                <div>
                    <a href="{{ url('/login') }}" class="text-lg font-semibold text-yellow-500 no-underline">
                        {{ config('app.name', 'Klosz') }}
                    </a>
                  <img  id="image" src="{{ asset('storage/logo/klosz_logo.png') }}"  class=" ml-4 h-16 w-16 inline" alt="Logo">
                </div>
                <div class="text-right text-center ">
                    @guest
                        <a class="no-underline hover:underline  text-sm p-3"
                           href="{{ route('login') }}">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                            <a class="no-underline hover:underline  text-sm p-3"
                               href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    @else
                        <span class="md:hidden text-gray-300 text-sm p-3">{{ Auth::user()->name[0] }}. {{ Auth::user()->surname[0] }}.</span>
                        <span
                            class="hidden md:inline-block text-gray-300 text-sm p-3">{{ Auth::user()->name }} {{ Auth::user()->surname }}</span>
                        @can('update')
                            <a href="{{ route('admin.home') }}"
                               class="no-underline hover:underline  text-sm p-3"> Admin
                            </a>
                        @endcan
                        <a href="{{ route('logout') }}"
                           class="no-underline hover:underline  text-sm py-3"
                           onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto  md:flex ">
        @yield('content')
    </div>
</div>
<div class="container  p-10 mx-auto items-center bg-white">
    <h6 class="text-sm text-center text-gray-300">Klosz Group 2020 &copy;</h6>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
