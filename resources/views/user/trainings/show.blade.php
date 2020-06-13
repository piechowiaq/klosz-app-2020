@extends('layouts.app')

@section('content')

    @include('user.nav')
    <div class="md:w-5/6 md:m-0 m-2">
        <div class="block font-semibold ">
            <h1 class="text-lg block pb-2 ">{{$training->name}}</h1>
        </div>
        <div class="w-4/6  block mt-2 py-2">
            <a href="{{route('user.certificates.index', ['company'=>$company->id, 'training'=> $training->id, ])}}">History</a>
        </div>
        <hr>

        <hr>

        <div>
            @foreach ($trainingEmployees as $employee)
                <div class="flex content-between flex-wrap" >
                    <div class="w-4/6  block mt-2 py-2">
                        {{ $employee->full_name}}
                    </div>


                    @foreach ($employee->certificates->where('training_id', $training->id)->sortByDesc('training_date') as $certificate)

                        @if($loop->first)
                            <div class="w-1/6  text-right block mt-2 py-2">
                                {{ $certificate->training_date}}
                            </div>

                            <div class="w-1/6 text-right block mt-2 py-2">
                                @if(  Carbon\Carbon::now()->subDays(30) > $certificate->expiry_date)
                                    <svg class="inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M15 19a3 3 0 0 1-6 0H4a1 1 0 0 1 0-2h1v-6a7 7 0 0 1 4.02-6.34 3 3 0 0 1 5.96 0A7 7 0 0 1 19 11v6h1a1 1 0 0 1 0 2h-5zm-4 0a1 1 0 0 0 2 0h-2zm0-12.9A5 5 0 0 0 7 11v6h10v-6a5 5 0 0 0-4-4.9V5a1 1 0 0 0-2 0v1.1z"/></svg>
                                @endif {{ $certificate->expiry_date}}
                            </div>


                        @endif



                    @endforeach
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
