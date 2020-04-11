@extends('layouts.app')

@section('content')
    @include('user.nav')
    <div class="md:w-5/6">
        @can('update', $report)
            <div class=" py-6 m-2 md:py-2">
                <a href="{{route('user.reports.create', ['company'=>$company])}}" class="rounded border text-indigo-500 p-2 bg-transparent" >Dodaj Raport</a>
            </div>
        @endcan
        @foreach ($companyRegistries as $registry)

            <div class="md:flex border  mb-1">
                <div class="m-2 p-2 py-2 md:w-11/12 ">
                    <a href="{{route('user.registries.show', ['registry'=> $registry, 'company'=>$company->id])}}">{{ $registry->name}}</a>
                </div>

            </div>
        @endforeach
    </div>
@endsection
