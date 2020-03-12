@extends('layouts.app')
@section('title', 'Companies')
@section('content')
    @include('user.nav')
    <div class="md:w-5/6">
    <div>
        <div> <h1>Pracownicy</h1></div>
    </div>


    <div>
        <form action="{{route('user.employees.update', ['company'=>$company->id, 'employee' => $employee])}}" method="POST" enctype="multipart/form-data">

            @method('PATCH')

            @include('user.employees.form')

            <button type="submit" class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">Edytuj Pracownika</button>

            @include('errors')

        </form>
    </div>
    </div>



@endsection
