@extends('layouts.app')

@section('content')

    @include('admin.nav')
    <div class="md:w-5/6">
    <div class="block mt-2 py-2">
        <h1>{{$company->name}} </h1>
    </div>
    <hr>
    <div>
        @foreach ($company->users as $user)
            <div class="block mt-2 py-2">
                {{ $user->full_name}}
            </div>
        @endforeach
    </div>
    <hr>
        <div>
            <label class="block mt-2 py-2">Pozycje:</label>
{{--            <form action="{{route('admin.companies.active', ['company' => $company])}}" method="POST">--}}
            @foreach ($company->positions as $position)
                <div class="block mt-2 py-2">

{{--                        @method('PATCH')--}}

{{--                        <input type="checkbox" name="position_active[]" id="position_active" class="mr-2 leading-tight" multiple="multiple" value="{{$position->pivot->id}}" {{$position->pivot->active  ? 'checked': ''  || ( old('position_active') ? 'checked="checked"' : '' )}}>--}}
{{--                        --}}
                        {{ $position->name}}

                </div>
            @endforeach

{{--                @csrf--}}
{{--                <button type="submit" class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">Dodaj Firmę</button>--}}

{{--            </form>--}}
        </div>
        <hr>
        <div>
            <label class="block mt-2 py-2">Działy:</label>
            @foreach ($company->departments as $department)
                <div class="block mt-2 py-2">
                    {{ $department->name}}
                </div>
            @endforeach
        </div>



    </div>
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
