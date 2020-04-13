@extends('layouts.app')

@section('content')

    @include('user.nav')

    <div class="md:w-5/6">
        <div class=" py-6 m-2 md:py-2">
            {{$registry->name}}
        </div>

        @foreach ($registry->reports as $report)

            <div class="md:flex border mb-1">

                <div class="m-2 p-2 py-2 md:w-5/6 ">

                    {{$report->report_date}}

                </div>

                <div class="flex  justify-center md:justify-end md:w-1/6 ">
                    @can('update', $report)
                    <div class=" px-2 bg-transparent hover:bg-blue-500 text-black-700 hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">
                        <a href="{{route('user.reports.edit', ['report'=> $report, 'company'=>$company->id])}}" class="">Edytuj</a>
                    </div>
                    @endcan
                    @can('update', $report)
                    <div class="px-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">

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

@endsection
