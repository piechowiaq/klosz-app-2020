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
<body class=" h-screen antialiased leading-none">
    <div id="app">
        <nav class="bg-indigo-500 shadow mb-4 py-2">
            <div class="container mx-auto px-6 md:px-0">
                <div class="flex items-center justify-between text-yellow-500">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="text-lg font-semibold text-yellow-500 no-underline">
                            {{ config('app.name', 'Klosz') }}


                        </a><img src="{{ asset('/png/logo.png') }}"  class=" ml-4 h-16 w-16 inline" alt="Logo">
                    </div>

                    <div></div>
                    <div class="text-right text-center ">
                        @guest
                            <a class="no-underline hover:underline  text-sm p-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @if (Route::has('register'))
                                <a class="no-underline hover:underline  text-sm p-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        @else
                            <span class="text-gray-300 text-sm p-3">{{ Auth::user()->name }} {{ Auth::user()->surname }}</span>
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

        <div class="container mx-auto  flex ">

        @yield('content')


        </div>
    </div>
    <div class="container  p-10 mx-auto items-center bg-white">

        <h6 class="text-sm text-center text-gray-300">Klosz Group 2020 &copy;</h6>
    </div>

    <!-- Scripts -->



{{--    <p id="demo"></p>--}}

{{--    <script>--}}
{{--        document.getElementById("demo").innerHTML = "My First JavaScript";--}}
{{--    </script>--}}

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/RegistryChart.js') }}"></script>


{{--<script>--}}

{{--     new Chart(document.getElementById('myChart').getContext('2d'), {--}}
{{--        type: 'bar',--}}
{{--        data: {--}}
{{--            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],--}}
{{--            datasets: [{--}}
{{--                label: '# of Votes',--}}
{{--                data: [12, 19, 3, 5, 2, 3],--}}
{{--                backgroundColor: [--}}
{{--                    'rgba(255, 99, 132, 0.2)',--}}
{{--                    'rgba(54, 162, 235, 0.2)',--}}
{{--                    'rgba(255, 206, 86, 0.2)',--}}
{{--                    'rgba(75, 192, 192, 0.2)',--}}
{{--                    'rgba(153, 102, 255, 0.2)',--}}
{{--                    'rgba(255, 159, 64, 0.2)'--}}
{{--                ],--}}
{{--                borderColor: [--}}
{{--                    'rgba(255, 99, 132, 1)',--}}
{{--                    'rgba(54, 162, 235, 1)',--}}
{{--                    'rgba(255, 206, 86, 1)',--}}
{{--                    'rgba(75, 192, 192, 1)',--}}
{{--                    'rgba(153, 102, 255, 1)',--}}
{{--                    'rgba(255, 159, 64, 1)'--}}
{{--                ],--}}
{{--                borderWidth: 1--}}
{{--            }]--}}
{{--        },--}}
{{--        options: {--}}
{{--            scales: {--}}
{{--                yAxes: [{--}}
{{--                    ticks: {--}}
{{--                        beginAtZero: true--}}
{{--                    }--}}
{{--                }]--}}
{{--            }--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}




</body>

</html>
