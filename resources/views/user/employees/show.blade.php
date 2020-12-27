@extends('layouts.app')
@section('content')
    @include('user.nav')
    @php
        /**
        * @var App\Employee $employee
        */
    @endphp
    <div class="md:w-5/6 md:m-0 m-2">
        <div class="block font-semibold ">
            <h1 class="text-lg ">{{$employee->full_name}} </h1>
        </div>
        <div>
            @foreach ($employee->getPositions() as $position)
                <div class="block mt-2 py-2">
                    {{ $position->getName()}}
                </div>
            @endforeach
        </div>
        <hr>
        <div>
            @foreach ($employee->getTrainings() as $training)
                <div class="flex content-between flex-wrap">
                    <div class="w-4/6  block mt-2 py-2">
                        {{ $training->getName()}}
                    </div>
                    @foreach ($employee->getCertificates()->where('training_id', $training->getId())->sortByDesc('training_date') as $certificate)

                        @if($loop->first)
                            <div class="w-1/6  text-right block mt-2 py-2">
                                {{ $certificate->getTrainingDate()->format('Y-m-d')}}
                            </div>

                            <div class="w-1/6 text-right block mt-2 py-2">
                                @if(  Carbon\Carbon::now()->subDays(30) > $certificate->getExpiryDate())
                                    <svg class="inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         width="24" height="24">
                                        <path class="heroicon-ui"
                                              d="M15 19a3 3 0 0 1-6 0H4a1 1 0 0 1 0-2h1v-6a7 7 0 0 1 4.02-6.34 3 3 0 0 1 5.96 0A7 7 0 0 1 19 11v6h1a1 1 0 0 1 0 2h-5zm-4 0a1 1 0 0 0 2 0h-2zm0-12.9A5 5 0 0 0 7 11v6h10v-6a5 5 0 0 0-4-4.9V5a1 1 0 0 0-2 0v1.1z"/>
                                    </svg>
                                @endif
                                    {{ $certificate->getExpiryDate()->format('Y-m-d')}}
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
