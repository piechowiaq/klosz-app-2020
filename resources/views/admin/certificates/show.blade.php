@extends('layouts.app')

@section('content')

    @include('admin.nav')
    <div class="md:w-5/6">
    <div class="block mt-2 py-2">
        <h1>{{$certificate->training->name}}  </h1>
    </div>

        Lalka
    <hr>
        <div class="block mt-2 py-2">
            <h1>{{$certificate->training_date}} </h1>
        </div>

        <div class="block mt-2 py-2">
            <h1>{{$certificate->expiry_date}} </h1>
        </div>
{{--    <div>--}}
{{--        @foreach ($certificate->training as $training)--}}
{{--            <div class="block mt-2 py-2">--}}
{{--                {{ $training->name}}--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--    <hr>--}}
{{--        <div>--}}
{{--            @foreach ($certificate->company as $company)--}}
{{--                <div class="block mt-2 py-2">--}}
{{--                    {{ $company->name}}--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}



{{--    </div>--}}
{{--    <div>--}}
{{--        @foreach ($user->companies as $company)--}}
{{--            <div class="block mt-2 py-2">--}}
{{--                {{ $company->name}}--}}
{{--            </div>--}}


{{--        @endforeach--}}
{{--    </div>--}}




    {{--    <div class=" py-6 m-2 md:py-2">--}}

    {{--        <a href="{{route('users.create')}}" class="rounded border text-indigo-500 p-2 bg-transparent" >Create User</a>--}}

    {{--    </div>--}}

    {{--    @foreach ($users as $user)--}}

    {{--        <div class="md:flex border rounded shadow mb-1">--}}

    {{--            <div class="m-2 p-2 py-2 md:w-5/6 ">--}}
    {{--                {{ $user->name}} {{ $user->surname}}--}}
    {{--            </div>--}}

    {{--            <div class="flex  justify-center md:justify-end md:w-1/6 ">--}}

    {{--                <div class=" px-2 bg-transparent hover:bg-blue-500 text-black-700 hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">--}}
    {{--                    <a href="{{route('users.edit', ['user'=> $user])}}" class="">Edytuj</a>--}}
    {{--                </div>--}}

    {{--                <div class="px-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">--}}
    {{--                    <form action="#" method="POST">--}}
    {{--                        @method('DELETE')--}}
    {{--                        @csrf--}}
    {{--                        <button type="submit" class="">Usuń</button>--}}
    {{--                    </form>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}

    {{--    @endforeach--}}

@endsection
