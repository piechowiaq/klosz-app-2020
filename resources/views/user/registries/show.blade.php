@extends('layouts.app')
@section('content')
    @include('user.nav')
    @php
    /**
    * @var App\Registry $registry
    * @var App\Company $company
    */
    @endphp
    <div class="md:w-5/6 md:m-0 m-2">
        <div class=" py-6 m-2 md:py-2">
            {{$registry->getName()}}
        </div>
        @foreach ($registry->getReports() as $report)
            <div class="md:flex border mb-1">
                <div class="m-2 p-2 py-2 md:w-5/6 ">
                    {{$report->getReportDate()->format('Y-m-d')}}
                </div>
                <div class="flex  justify-center md:justify-end md:w-1/6 ">
                    @can('update', $report)
                        <div
                            class=" px-2 bg-transparent hover:bg-blue-500 text-black-700 hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">
                            <a href="{{route('user.reports.edit', ['report'=> $report, 'company'=>$company])}}"
                               class="">Edytuj</a>
                        </div>
                    @endcan
                    @can('update', $report)
                        <div
                            class="px-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">
                            <form
                                action="{{route('user.reports.destroy', ['report'=> $report, 'company'=>$company])}}"
                                method="POST">
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
