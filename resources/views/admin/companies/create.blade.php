@extends('layouts.admin')

@section('content')

    <div class="">

        <div> <h1>Create Comapany</h1></div>

        <div>

            <form action="{{route('companies.store')}}" method="POST">

                @include('admin.companies.form')

                <button type="submit" class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">Dodaj Firmę</button>

                {{--                @include('errors')--}}

            </form>

        </div>

    </div>


@endsection
