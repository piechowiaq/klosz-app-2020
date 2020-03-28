@extends('layouts.app')

@section('content')
    @include('user.nav')
    <div class="md:w-5/6">
        @can('update', $employee)
    <div class=" py-6 m-2 md:py-2">
        <a href="{{route('user.employees.create', ['company'=>$company])}}" class="rounded border text-indigo-500 p-2 bg-transparent" >Dodaj Pracownika</a>
    </div>
        @endcan
    @foreach ($employees as $employee)

        <div class="md:flex border  mb-1">

            <div class="m-2 p-2 py-2 md:w-5/6 ">

                <a href="{{route('user.employees.show', ['employee'=> $employee, 'company'=>$company->id])}}">{{ $employee->full_name}}</a>


            </div>

            <div class="flex  justify-center md:justify-end md:w-1/6 ">
                @can('update', $employee)
                <div class=" px-2 bg-transparent hover:bg-indigo-500 hover:text-yellow-500 text-indigo-500 hover:border-transparent  m-2 py-2 ">
                    <a href="{{route('user.employees.edit', ['employee'=> $employee, 'company'=>$company->id])}}" class="">Edytuj</a>
                </div>
                @endcan
            </div>

        </div>

    @endforeach
    </div>
@endsection
