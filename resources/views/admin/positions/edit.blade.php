@extends('layouts.app')
@section('title', 'Departments')
@section('content')
    @include('admin.nav')
    @php
        /**
        * @var App\Position $position
        */
    @endphp
    <div class="md:w-5/6">
        <div>
            <div> <h1>Departments</h1></div>
        </div>
        <div>
           <form action="{{route('admin.positions.update', ['position' => $position])}}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @include('admin.positions.form')
                <button type="submit" class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">Edytuj Pozycje</button>
                @include('errors')
            </form>
        </div>
    </div>
@endsection
