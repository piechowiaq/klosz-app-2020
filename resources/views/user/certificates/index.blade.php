@extends('layouts.app')

@section('content')
    @include('user.nav')
    <div class="md:w-5/6">
    <div class=" py-6 m-2 md:py-2">
        <a href="{{route('user.certificates.create',['company'=>$company])}}" class="rounded border text-indigo-500 p-2 bg-transparent" >Create Certificate</a>
    </div>

    @foreach ($certificates as $certificate)

        <div class="md:flex border rounded shadow mb-1">

            <div class="m-2 p-2 py-2 md:w-5/6 ">

                <a href="{{route('user.certificates.show', ['company'=>$company, 'certificate'=>$certificate])}}">{{ $certificate->name}}</a>

            </div>

            <div class="flex  justify-center md:justify-end md:w-1/6 ">

                <div class=" px-2 bg-transparent hover:bg-blue-500 text-black-700 hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">
                    <a href="{{route('user.certificates.edit', ['company'=>$company, 'certificate'=> $certificate])}}" class="">Edytuj</a>
                </div>

                <div class="px-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">

                    <form action="{{route('user.certificates.destroy', ['company'=>$company, 'certificate'=> $certificate])}}" method="POST">

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
