@extends('layouts.app')
@section('content')
    @include('admin.nav')
    <div class="md:w-5/6">
        <div class="">
            <div class=""><h1>Create User</h1></div>
            <div class="">
                <form action="{{route('admin.users.store')}}" method="POST">
                    @include('admin.users.form')
                    <button type="submit"
                            class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">
                        Dodaj Użytkownika
                    </button>
                    @include('errors')
                </form>
            </div>
        </div>
    </div>
@endsection








