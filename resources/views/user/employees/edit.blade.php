@extends('layouts.app')
@section('title', 'Companies')
@section('content')
    @include('user.nav')
    @php
        /**
        * @var App\Company $company
        * @var App\Employee $employee
        */
    @endphp
    <div class="md:w-5/6 md:m-0 m-2">
        <div>
            <div><h1 class="text-lg font-semibold pb-2">Edytuj Pracownika</h1></div>
        </div>
        <hr>
        <div>
            <form action="{{route('user.employees.update', ['company'=>$company, 'employee' => $employee])}}"
                  method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @include('user.employees.form')
                <button type="submit"
                        class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">
                    Edytuj Pracownika
                </button>
                @include('errors')
            </form>
        </div>
    </div>
@endsection
