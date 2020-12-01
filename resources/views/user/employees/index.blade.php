@extends('layouts.app')

@section('content')
    @include('user.nav')
    <div class="md:w-5/6 md:m-0 m-2">
        <div class="md:flex md:justify-between mb-4">
            @can('update', $employee)
                <div class="rounded border bg-transparent text-center md:mt-0 mt-4">
                        <div class="py-2 px-4 leading-tight text-indigo-500 focus:outline-none focus:border-indigo-500">
                            <a href="{{route('user.employees.create', ['company'=>$company])}}">Dodaj Pracownika</a>
                        </div>
                </div>
            @endcan
            <div>
                <form method="GET" action="{{route('user.search.show', ['company'=> $company])}}">
                    <input type="search" placeholder="Szukaj ..." name="q" class="md:mt-0 mt-4 bg-gray-200 appearance-none w-full border border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500">
{{--                    <button type="submit" >Szukaj</button>--}}
                </form>
            </div>
        </div>
{{--        @livewire('search-employees', ['company'=>$company])--}}


{{--        <search>   </search>--}}
        @foreach ($employees as $employee)

            <div class="md:flex md:text-left text-center border mb-1">

                <div class="m-2 p-2 md:w-5/6 ">

                    <a href="{{route('user.employees.show', ['employee'=> $employee, 'company'=>$company])}}">{{ $employee->full_name}}</a>

                </div>

                <div class="flex  justify-center md:justify-end md:w-1/6 ">
                    @can('update', $employee)
                    <div class=" px-2 bg-transparent hover:bg-blue-500 text-black-700 hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">
                        <a href="{{route('user.employees.edit', ['employee'=> $employee, 'company'=>$company])}}" class="">Edytuj</a>
                    </div>
                    @endcan
                    @can('update', $employee)
                    <div class="px-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">

                        <form action="{{route('user.employees.destroy', ['employee'=> $employee, 'company'=>$company])}}" method="POST">

                            @method('DELETE')

                            @csrf

                            <button type="submit" class="">Usuń</button>

                        </form>

                    </div>

                     @endcan
                </div>

            </div>

        @endforeach
    </div>

@endsection
