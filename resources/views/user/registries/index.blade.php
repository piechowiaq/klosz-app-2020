@extends('layouts.app')

@section('content')
    @include('user.nav')
    <div class="md:w-5/6 md:m-0 m-2">
        <div class="md:flex md:justify-between mb-4">
            @can('update', $report)
                <div class="md:mt-0 mt-4 rounded border bg-transparent text-center">
                    <div class="py-2 px-4 leading-tight text-indigo-500 focus:outline-none focus:border-indigo-500">
                        <a href="{{route('user.reports.create', ['company'=>$company])}}">Dodaj Raport</a>
                    </div>
                </div>
            @endcan
            <div>
                <form method="GET" action="{{route('user.search.registries', ['company'=> $company])}}">
                    <input type="search" placeholder="Szukaj ..." name="q" class="md:mt-0 mt-4 bg-gray-200 w-full appearance-none border border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500">
                    {{--                    <button type="submit" >Szukaj</button>--}}
                </form>
            </div>
        </div>
        {{--        @livewire('search-employees', ['company'=>$company])--}}


        {{--        <search>   </search>--}}
        @foreach ($companyRegistries as $registry)

            <div class="md:flex border  text-center md:text-left mb-1">
                <div class="m-2 p-2 py-2 md:w-8/12 ">
                    <a href="{{route('user.registries.show', ['registry'=> $registry, 'company'=>$company->id])}}">{{ $registry->name}}</a>
                </div>

                @foreach ($registry->reports->where('company_id', $company->id)->sortByDesc('report_date') as $report)

                    @if($loop->first)
                    <div class="md:w-4/12 flex justify-around">
                        <div class=" mt-2 py-2 ">
                            @if(  Carbon\Carbon::now()->subDays(30) > $report->expiry_date)
                                <svg class="inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M15 19a3 3 0 0 1-6 0H4a1 1 0 0 1 0-2h1v-6a7 7 0 0 1 4.02-6.34 3 3 0 0 1 5.96 0A7 7 0 0 1 19 11v6h1a1 1 0 0 1 0 2h-5zm-4 0a1 1 0 0 0 2 0h-2zm0-12.9A5 5 0 0 0 7 11v6h10v-6a5 5 0 0 0-4-4.9V5a1 1 0 0 0-2 0v1.1z"/></svg>
                            @endif Wygasa: {{ $report->expiry_date}}
                        </div>
                        <div class=" px-2 bg-transparent text-black-700 hover:text-indigo-700 text-indigo-500 rounded m-2 py-2 ">
                            <a href="{{ route('user.reports.download', ['company'=> $company->id, 'report'=>$report]) }}" class="">Download</a>
                        </div>

                    </div>
                    @endif

                @endforeach

            </div>
        @endforeach
    </div>

@endsection


