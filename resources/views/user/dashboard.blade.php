@extends('layouts.app')

@section('content')

    @include('user.nav')

    <div class="w-full flex justify-around">
        <div class="my-4 ml-4 mr-2 p-4 w-1/2">

            <div class="flex justify-around">
                <div class="bg-indigo-100 w-full  ">

<div class="w-32 h-32">

    {{$registryChart->container()}}
</div>











                </div>

                <div class="bg-indigo-200 w-full leading-loose px-2">
                    <h2 class="text-lg text-indigo-500 font-bold">Rejestr</h2>
                    <ul class="text-gray-900 text-sm text-justify">
                        <li>Wszystkich: <span class="font-bold text-indigo-500">20</span></li>
                        <li>Aktualne: <span class="font-bold text-indigo-500">10</span></li>
                        <li>Nieaktualne: <span class="font-bold text-indigo-500">10</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="my-4 ml-4 mr-2 p-4 w-1/2">

            <div class="flex justify-around">
                <div class="bg-indigo-100 w-full  ">
                    Chart
                </div>

                <div class="bg-indigo-300 w-full leading-loose px-2">
                    <h2 class="text-lg text-indigo-500 font-bold">Rejestr</h2>
                    <ul class="text-gray-900 text-sm text-justify">
                        <li>Wszystkich: <span class="font-bold">20</span></li>
                        <li>Aktualne: <span class="font-bold">10</span></li>
                        <li>Nieaktualne: <span class="font-bold">10</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
