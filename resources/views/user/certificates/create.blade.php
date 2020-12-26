@extends('layouts.app')
@section('content')
    @include('user.nav')
    @php
        /**
        * @var App\Company $company
        * @var App\Training $training
        */
    @endphp
    <div class="md:w-5/6 md:m-0 m-2">
        <div class="">
            <div><h1 class="text-lg font-semibold pb-2">Dodaj Dyplom</h1></div>
            <hr>
            <div>
                <form
                    action="{{route('user.certificates.store', ['company'=>$company ?? 'company', 'training'=>$training ?? 'training'])}}"
                    method="POST" enctype="multipart/form-data">
                    @include('user.certificates.form')
                    <button type="submit"
                            class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">
                        Dodaj Dyplom
                    </button>
                    @include('errors')
                </form>
            </div>
        </div>
    </div>
@endsection
