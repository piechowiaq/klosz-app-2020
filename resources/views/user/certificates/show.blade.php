@extends('layouts.app')
@section('content')
    @include('user.nav')
    @php
        /**
        * @var App\Certificate $certificate
        */
    @endphp
    <div class="md:w-5/6 md:m-0 m-2 md:text-left text-center">
        <div class="block mt-2 py-2">
            <h1>{{$certificate->getTraining()->getName()}} </h1>
        </div>
        <hr>
        <div class="block mt-2 py-2">
            <h1><span class="text-gray-500">Data szkolenia: </span>{{$certificate->getTrainingDate()->format('Y-m-d')}}
            </h1>
        </div>
        <div class="block mt-2 py-2">
            <h1><span class="text-gray-500">Szkolenie wygasa:</span> {{$certificate->getExpiryDate()->format('Y-m-d')}}
            </h1>
        </div>
@endsection
