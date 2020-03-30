@extends('layouts.app')

@section('content')
    @include('user.nav')
    <div class="md:w-5/6">
        @can('update', $certificate)
    <div class=" py-6 m-2 md:py-2">
        <a href="{{route('user.certificates.create', ['company'=>$company])}}" class="rounded border text-indigo-500 p-2 bg-transparent" >Dodaj Dyplom</a>
    </div>
        @endcan
    @foreach ($trainings as $training)

                <div class="md:flex border  mb-1">
                    <div class="m-2 p-2 py-2 md:w-11/12 ">
                        <a href="{{route('user.trainings.show', ['training'=> $training, 'company'=>$company->id])}}">{{ $training->name}}</a>
                    </div>
                    <div class="m-2 p-2 py-2 md:w-1/12">
                        {{round($training->employees()->whereHas('certificates', function($q) use ($training) {
                                                         $q->where('expiry_date', '>', \Carbon\Carbon::now())
                                                           ->where('training_id', $training->id);
                                                           })->count()/$training->employees()->count()*100)}} %
                    </div>

                 </div>
    @endforeach
    </div>
@endsection
