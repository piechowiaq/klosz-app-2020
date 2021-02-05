@extends('layouts.app')
@section('content')
    @include('user.nav')
    @php
        /**
        * @var App\Report $report
        * @var App\Company $company
        * @var Illuminate\Database\Eloquent\Collection | App\Registry[] $companyRegistries
        */
    @endphp
    <div class="md:w-5/6 md:m-0 m-2">
        <div class="md:flex md:justify-between mb-4">
            @can('create', $report)
                <div class="md:mt-0 mt-4 rounded border bg-transparent text-center">
                    <div class="py-2 px-4 leading-tight text-indigo-500 focus:outline-none focus:border-indigo-500">
                        <a href="{{route('user.reports.create', ['company'=>$company])}}">Dodaj Raport</a>
                    </div>
                </div>
            @endcan
            <div>
                <form method="GET" action="">
                    <input type="search" placeholder="Szukaj ..." name="q"
                           class="md:mt-0 mt-4 bg-gray-200 w-full appearance-none border border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500">
                </form>
            </div>
        </div>
        <table class="table-fixed ">
            <thead class="text-gray-500 text-center ">
            <tr>
                <th class="w-7/12 px-4 py-2">Rejestr</th>
                <th class="w-1/12 px-4 py-2">Ściągnij</th>
                <th class="w-1/12 px-4 py-2">Status</th>
                <th class="w-2/12 px-4 py-2">Data ważności</th>
                <th class="w-1/12 px-4 py-2">Szczegóły</th>
            </tr>
            </thead>
            <tbody class="text-sm ">
            @foreach ($companyRegistries as $registry)
                <tr class="border-indigo-500 border-t border-b">
                    <td class=" px-4 py-2 ">
                        <a href="{{route('user.registries.show', ['registry'=> $registry, 'company'=>$company])}}">{{ $registry->getName()}}</a>
                    </td>
                    @forelse ($registry->getReports()->where('company_id', $company->getId())->sortByDesc('report_date') as $report)
                        @if($loop->first)
                            <td class="text-center">
                                <a href="{{ route('user.reports.download', ['company'=> $company, 'report'=>$report]) }}"
                                   class="text-center">Download</a>
                            </td>
                            <td class="text-center ">
                                @if( \Carbon\Carbon::parse($report->getExpiryDate())->subDays(30) < \Carbon\Carbon::now())
                                    <svg class="inline" viewBox="0 0 24 24" width="24" height="24">
                                        <path class="heroicon-ui"
                                              d="M15 19a3 3 0 0 1-6 0H4a1 1 0 0 1 0-2h1v-6a7 7 0 0 1 4.02-6.34 3 3 0 0 1 5.96 0A7 7 0 0 1 19 11v6h1a1 1 0 0 1 0 2h-5zm-4 0a1 1 0 0 0 2 0h-2zm0-12.9A5 5 0 0 0 7 11v6h10v-6a5 5 0 0 0-4-4.9V5a1 1 0 0 0-2 0v1.1z"/>
                                    </svg>
                                @endif
                            </td>
                            <td class="text-center  bg-indigo-400">
                                {{ $report->getExpiryDate()->format('Y-m-d')}}
                                {{ \Carbon\Carbon::parse($report->getExpiryDate())->diffInDays(\Carbon\Carbon::now()) }}
                            </td>
                        @endif
                    @empty
                        <td></td>
                        <td></td>
                        <td></td>
                    @endforelse
                    <td class="text-center">
                        Szczegóły
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection


