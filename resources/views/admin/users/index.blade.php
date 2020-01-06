@extends('layouts.admin')

@section('content')

    <div class="">

        <div class="">
            <div class=" m-2 py-2 bg-transparent">
                <a href="{{route('users.create')}}" class="  rounded border border-red-500 p-2 bg-transparent" >Create User</a>
            </div>

        </div>

        <div class="">
            @foreach ($users as $user)

                <div class="flex">

                    <div class="m-2 pl-2 py-2 w-5/6 bg-red-100">
                       {{ $user->name}} {{ $user->surname}}
                    </div>

                    <div class=" text-center flex w-1/6">

                        <div class=" px-2 bg-transparent hover:bg-blue-500 text-black-700 hover:text-white border border-red-500 hover:border-transparent rounded m-2 py-2 ">
                            <a href="#" class="">Edytuj</a>
                        </div>

                        <div class="px-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border border-red-500 hover:border-transparent rounded m-2 py-2 ">
                            <form action="#" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="">Usuń</button>
                            </form>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>

    </div>

@endsection
