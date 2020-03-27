@extends('layouts.app')

@section('content')
    @include('user.nav')
    <div class="md:w-5/6">
        @can('update', $certificate)
    <div class=" py-6 m-2 md:py-2">
        <a href="{{route('user.certificates.create', ['company'=>$company])}}" class="rounded border text-indigo-500 p-2 bg-transparent" >Add Certificate</a>
    </div>
        @endcan
    @foreach ($trainings as $training)

        <div class="md:flex border rounded shadow mb-1">

            <div class="m-2 p-2 py-2 md:w-5/6 ">

                <a href="{{route('user.trainings.show', ['training'=> $training, 'company'=>$company->id])}}">{{ $training->name}} </a>


            </div>

            <div class="flex  justify-center md:justify-end md:w-1/6 ">
                @can('update')
                <div class=" px-2 bg-transparent hover:bg-blue-500 text-black-700 hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">
                    <a href="{{route('user.employees.edit', ['employee'=> $employee, 'company'=>$company->id])}}" class="">Edytuj</a>
                </div>
                @endcan
            </div>

        </div>

    @endforeach
    </div>
@endsection
