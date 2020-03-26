@extends('layouts.app')
@section('title', 'Certificates')
@section('content')
    @include('admin.nav')
    <div class="md:w-5/6">
    <div>
        <div> <h1>Certifikaty</h1></div>
    </div>


    <div>
        <form action="{{route('admin.certificates.update', ['certificate' => $certificate])}}" method="POST" enctype="multipart/form-data">

            @method('PATCH')

            @include('admin.certificates.form')

            <button type="submit" class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">Edytuj Certifikat</button>

            @include('errors')

        </form>
    </div>
    </div>



@endsection
