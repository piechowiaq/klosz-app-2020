@extends('layouts.app')
@section('title', 'Companies')
@section('content')
    @include('admin.nav')
    @php
        /**
        * @var App\Company $company
        * /
    @endphp
    <div class="md:w-5/6">
        <div>
            <div><h1>Firmy</h1></div>
        </div>
        <div>
            <form action="{{route('admin.companies.update', ['company' => $company])}}" method="POST">
                @method('PATCH')
                @include('admin.companies.form')
                <button type="submit"
                        class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">
                    Edytuj Firmę
                </button>
                @include('errors')
            </form>
        </div>
    </div>
@endsection
