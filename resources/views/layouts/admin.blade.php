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
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">
    <div id="app">
        <nav class="bg-indigo-500 shadow mb-8 py-6">
            <div class="container mx-auto px-6 md:px-0">
                <div class="flex items-center justify-between">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                            {{ config('app.name', 'Klosz') }}
                        </a>
                    </div>
                    <div class="text-right">
                        @guest
                            <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @if (Route::has('register'))
                                <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        @else
                            <span class="text-gray-300 text-sm pr-4">{{ Auth::user()->name }} {{ Auth::user()->surname }}</span>

                            <a href="{{ route('logout') }}"
                               class="no-underline hover:underline text-gray-300 text-sm p-3"
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
        <div class="container mx-auto items-center ">


                     <div class="bg-white border border-2 rounded shadow-md">

                        <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                            Admin Panel
                        </div>

                        <div class="md:flex p-6">
                            <div class="md:w-1/6">
                                <ul class="">
                                    <li class="md:mr-6">
                                        <a class="text-indigo-500 hover:text-red-800" href="{{ route('users.index') }}">Users</a>
                                    </li>
                                    <li class="md:mr-6 mt-6">
                                        <a class="text-indigo-500 hover:text-red-800" href="{{ route('roles.index') }}">Roles</a>
                                    </li>
                                    <li class="md:mr-6 mt-6">
                                        <a class="text-indigo-500 hover:text-red-800" href="{{ route('companies.index') }}">Companies</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="md:w-5/6">
                                @yield('content')
                            </div>
                        </div>

                     </div>

        </div>
    </div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
