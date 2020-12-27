@extends('layouts.app')
@section('content')
    @include('user.nav')
    <div class="w-full md:flex justify-around">
        <div class="my-4 ml-4 mr-2 p-4 md:w-1/2 h-full">
            <div class="md:flex justify-around h-full">
                <div class="bg-white md:w-2/3 mb-4 md:mb-0">
                    <chart id="registrychart" :data='[{{$registryChartValue}}, {{100-$registryChartValue}}]'></chart>
                </div>
                <div class="bg-indigo-100  text-center leading-loose p-4 md:w-1/3">
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
        <div class="my-4 ml-4 mr-2 p-4 md:w-1/2 h-full">
            <div class="md:flex justify-around h-full">
                <div class="bg-white md:w-2/3 mb-4 md:mb-0">
                    <chart id="trainingchart" :data='[{{$trainingChartValue}}, {{100-$trainingChartValue}}]'></chart>
                </div>
                <div class="bg-indigo-100  text-center leading-loose p-4 md:m-2 md:w-1/3">
                    <h2 class="text-lg text-indigo-500 font-bold">Szkolenia</h2>
                    <ul class="text-gray-700 text-sm ">
                        <li>Wszystkie:</li>
                        <li class="font-bold text-lg">{{$companyTrainings->count()}}</li>
                        <li>Aktualne:</li>
                        <li class="font-bold text-lg">{{$trainingChartValue}}%</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection



