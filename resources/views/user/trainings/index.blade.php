@extends('layouts.app')

@section('content')
    @include('user.nav')
    <div class="md:w-5/6">
        @can('update', $certificate)
    <div class=" py-6 m-2 md:py-2">
        <a href="{{route('user.certificates.create', ['company'=>$company])}}" class="rounded border text-indigo-500 p-2 bg-transparent" >Dodaj Dyplom</a>
    </div>
        @endcan
            @foreach ($companyTrainings as $training)

                <div class="md:flex border  mb-1">
                    <div class="m-2 p-2 py-2 md:w-11/12 ">
                        <a href="{{route('user.trainings.show', ['training'=> $training, 'company'=>$company->id])}}">{{ $training->name}}</a>
                    </div>
                    <div class="m-2 p-2 py-2 md:w-1/12">
                        {{ $training->employees->where('company_id', $companyId)->count() == 0 ? : (round($training->employees()->certified($training, $companyId)->count()/$training->employees->where('company_id', $companyId)->count()*100))}} %
                    </div>

                </div>
            @endforeach
    </div>
@endsection
