@extends('layouts.admin')
@section('title', 'Companies')
@section('content')

    <div>
        <div> <h1>Firmy</h1></div>
    </div>


    <div>
        <form action="{{route('companies.update', ['company' => $company])}}" method="POST" enctype="multipart/form-data">

            @method('PATCH')

            @include('admin.companies.form')

            <button type="submit" class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">Edytuj Firmę</button>

            @include('errors')

        </form>
    </div>


@endsection
