@extends('layouts.app')

@section('content')

    @include('user.nav')

    <div class="w-full flex justify-around">
        <div class="my-4 ml-4 mr-2 p-4 w-1/2 h-full">
            <div class="flex justify-around h-full">
                <div class="bg-white w-2/3">
                    <div class="mt-5">{{$registryChart->container()}}</div>

                </div>
                <div class="bg-indigo-100  text-center leading-loose p-4 w-1/3">
                    <h2 class="text-lg text-indigo-500 font-bold">Rejestr</h2>
                    <ul class="text-gray-700 text-sm ">
                        <li>Aktualne:</li>
                        <li class="font-bold text-lg">20</li>
                        <li>Niektulane:</li>
                        <li class="font-bold text-lg">20</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="my-4 ml-4 mr-2 p-4 w-1/2 h-full">
            <div class="flex justify-around h-full">
                <div class="bg-white  w-2/3 ">
                    <div class="mt-5">{{$trainingChart->container()}}</div>
                </div>

                <div class="bg-indigo-100  text-center leading-loose p-4 w-1/3">
                    <h2 class="text-lg text-indigo-500 font-bold">Szkolenia</h2>
                    <ul class="text-gray-700 text-sm ">
                        <li>Aktualne:</li>
                        <li class="font-bold text-lg">20</li>
                        <li>Niektulane:</li>
                        <li class="font-bold text-lg">20</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
