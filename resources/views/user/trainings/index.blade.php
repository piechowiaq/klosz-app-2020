@extends('layouts.app')

@section('content')
    @include('user.nav')
    <div class="md:w-5/6">
        <div class="flex justify-between mb-4">
            @can('update', $certificate)
                <div class="rounded border bg-transparent text-center">
                    <div class="py-2 px-4 leading-tight text-indigo-500 focus:outline-none focus:border-indigo-500">
                        <a href="{{route('user.certificates.create', ['company'=>$company])}}">Dodaj Dyplom</a>
                    </div>
                </div>
            @endcan
            <div>
                <form method="GET" action="{{route('user.search.trainings', ['company'=> $company])}}">
                    <input type="search" placeholder="Szukaj ..." name="q" class="bg-gray-200 appearance-none border border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500">
                    {{--                    <button type="submit" >Szukaj</button>--}}
                </form>
            </div>
        </div>


            @foreach ($companyTrainings as $training)

                <div class="md:flex border  mb-1">
                    <div class="m-2 p-2 py-2 md:w-11/12 ">
                        <a href="{{route('user.trainings.show', ['training'=> $training, 'company'=>$company->id])}}">{{ $training->name}}</a>
                    </div>
                    <div class="m-2 p-2 py-2 md:w-1/12">

                        {{ $training->employees->where('company_id', $companyId)->count() == 0 ? 0 : round($training->employees()->certified($training, $companyId)->count()/$training->employees->where('company_id', $companyId)->count()*100)}} %
                    </div>

                </div>
            @endforeach
    </div>
@endsection
