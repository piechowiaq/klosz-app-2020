@extends('layouts.app')

@section('content')

    @include('admin.nav')
    <div class="md:w-5/6">

    <div class=" py-6 m-2 md:py-2">

        <a href="{{route('trainings.create')}}" class="rounded border text-indigo-500 p-2 bg-transparent" >Create Training</a>

    </div>

    @foreach ($trainings as $training)

        <div class="md:flex border rounded shadow mb-1">

            <div class="m-2 p-2 py-2 md:w-5/6 ">

                <a href="{{route('trainings.show', ['training'=>$training])}}"> {{ $training->name}}</a>

            </div>

            <div class="flex  justify-center md:justify-end md:w-1/6 ">

                <div class=" px-2 bg-transparent hover:bg-blue-500 text-black-700 hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">

                    <a href="{{route('trainings.edit', ['training'=> $training])}}" class="">Edytuj</a>

                </div>

                <div class="px-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">

                    <form action="{{route('trainings.destroy', ['training'=> $training])}}" method="POST">

                        @method('DELETE')

                        @csrf

                        <button type="submit" class="">Usuń</button>

                    </form>

                </div>

            </div>
        </div>

    @endforeach
    </div>
@endsection
