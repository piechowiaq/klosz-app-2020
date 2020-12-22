@extends('layouts.app')
@section('title', 'Users')
@section('content')
    @include('admin.nav')
    @php
        /**
        * @var App\User $user
        */
    @endphp
    <div class="md:w-5/6">
        <div>
            <div><h1>Użytkownicy</h1></div>
        </div>
        <div>
            <form action="{{route('admin.users.update', ['user' => $user])}}" method="POST"
                  enctype="multipart/form-data">
                @method('PATCH')
                @include('admin.users.form')
                <button type="submit"
                        class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">
                    Edytuj Dyplom
                </button>
                @include('errors')
            </form>
        </div>
    </div>
@endsection
