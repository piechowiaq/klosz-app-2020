@extends('layouts.app')
@section('content')
    @include('user.nav')
    @php
        /**
        * @var App\Company $company
        */
    @endphp
    <div class="md:w-5/6 md:m-0 m-2">
        <div class="">
            <div><h1 class="text-lg font-semibold pb-2">Dodaj Pracownika</h1></div>
            <hr>
            <div>
                <form action="{{route('user.employees.store', ['company'=>$company ?? 'company'])}}" method="POST">
                    @include('user.employees.form')
                    <button type="submit"
                            class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">
                        Dodaj Pracownika
                    </button>
                    @include('errors')
                </form>
            </div>
        </div>
    </div>
@endsection
