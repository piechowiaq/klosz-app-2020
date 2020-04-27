@extends('layouts.app')

@section('content')

    @include('user.nav')

    <div class="w-full flex justify-around">
        <div class="my-4 ml-4 mr-2 p-4 w-1/2 h-full">
            <div class="flex justify-around h-full">
                <div class="bg-white w-2/3">
                    <canvas id="registryChart"></canvas>

                </div>
                <div class="bg-indigo-100  text-center leading-loose p-4 w-1/3">
                    <h2 class="text-lg text-indigo-500 font-bold">Rejestr</h2>
                    <ul class="text-gray-700 text-sm ">
                        <li>Wszystkie:</li>
                        <li class="font-bold text-lg">{{$companyRegistries->count()}}</li>
                        <li>Aktualne:</li>
                        <li class="font-bold text-lg">{{$registryChartValue}}%</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="my-4 ml-4 mr-2 p-4 w-1/2 h-full">
            <div class="flex justify-around h-full">
                <div class="bg-white  w-2/3 ">
                     <registry-chart></registry-chart>
                </div>


                <div class="bg-indigo-100  text-center leading-loose p-4 w-1/3">
                    <h2 class="text-lg text-indigo-500 font-bold">Szkolenia</h2>
                    <ul class="text-gray-700 text-sm ">
                        <li>Wszystkie:</li>
                        <li class="font-bold text-lg">{{$companyTrainings->count()}}</li>
                        <li>Aktualne:</li>
                        <li class="font-bold text-lg">{{$average}}%</li>

                    </ul>
                </div>
{{--                <canvas id="myBarChart"></canvas>--}}


            </div>
        </div>
    </div>

@push('charts-values')

    <script> window.registryChartValue = "{{$registryChartValue}}";</script>

 @endpush





@endsection
