@extends('layouts.admin')

@section('content')



    <div class="">

        <div class=""> <h1>Create Role</h1></div>

        <div class="">

            <form action="{{route('roles.store')}}" method="POST">
                @include('admin.roles.form')
                <button type="submit" class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">Dodaj Prawo</button>
                {{--                @include('errors')--}}
            </form>

        </div>

    </div>


@endsection
