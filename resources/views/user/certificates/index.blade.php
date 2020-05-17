@extends('layouts.app')

@section('content')
    @include('user.nav')
    <div class="md:w-5/6">
    <div class=" py-6 m-2 md:py-2">
       {{$training->name}}
    </div>

    @foreach ($training->certificates as $certificate)

        <div class="md:flex border mb-1">

            <div class="m-2 p-2 py-2 md:w-5/6 ">

                <a href="{{route('user.certificates.show', ['certificate'=>$certificate,'company'=>$company, 'training'=>$training, ])}}">{{ $certificate->training_date}}</a>

            </div>

            <div class="flex  justify-center md:justify-end md:w-1/6 ">

                <div class=" px-2 bg-transparent text-black-700 hover:text-indigo-700 text-indigo-500 rounded m-2 py-2 ">
                    <a href="{{ asset('storage/'.$certificate->certificate_path)}}" class="">Download</a>
                </div>

                <div class=" px-2 bg-transparent hover:bg-blue-500 text-black-700 hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">
                    <a href="{{route('user.certificates.edit', ['certificate'=>$certificate,'company'=>$company->id, 'training'=>$training, ])}}" class="">Edytuj</a>
                </div>

                <div class="px-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">

                    <form action="{{route('user.certificates.destroy', ['certificate'=>$certificate, 'company'=>$company, 'training'=>$training, ])}}" method="POST">

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
