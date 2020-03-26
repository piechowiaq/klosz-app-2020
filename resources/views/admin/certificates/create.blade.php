@extends('layouts.app')

@section('content')

    @include('admin.nav')


    <div class="md:w-5/6">

    <div class="">

        <div> <h1>Create Certificate</h1></div>

        <div>

            <form action="{{route('admin.certificates.store')}}" method="POST">

                @include('admin.certificates.form')

                <button type="submit" class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">Dodaj Certifikat</button>

               @include('errors')

            </form>

        </div>

    </div>



    </div>

@endsection
