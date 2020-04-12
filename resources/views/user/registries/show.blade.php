@extends('layouts.app')

@section('content')

    @include('user.nav')

    <div class="md:w-5/6">
        <div class="block font-semibold ">
            <h1 class="text-lg block pb-2 ">{{$registry->name}}</h1>
        </div>
        <div>
            @foreach ($registry->reports as $report)
                <div class="md:flex border  mb-1">
                    <div class="m-2 p-2 py-2 md:w-4/6 ">
                        {{$report->report_date}}
                    </div>
                    <div class="flex  justify-center md:justify-end md:w-1/6 ">
                        @can('update', $report)
                            <div class=" px-2 bg-transparent hover:bg-indigo-500 hover:text-yellow-500 text-indigo-500 hover:border-transparent  m-2 py-2 ">
                                <a href="{{route('user.reports.edit', ['report'=> $report, 'company'=>$company->id])}}" class="">Edytuj</a>
                            </div>
                        @endcan
                    </div>
                    <div class="flex  justify-center md:justify-end md:w-1/6 ">
                        @can('update', $report)
                            <div class=" px-2 bg-transparent hover:bg-indigo-500 hover:text-yellow-500 text-indigo-500 hover:border-transparent  m-2 py-2 ">
                                <form action="{{route('user.reports.destroy', ['report'=> $report, 'company'=>$company->id])}}" method="POST">

                                    @method('DELETE')

                                    @csrf

                                    <button type="submit" class="">Usuń</button>

                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>
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
