@extends('layouts.app')

@section('content')

    @include('user.nav')

    <div class="md:w-5/6">

        <div class="block font-semibold ">
            <h1 class="text-lg ">{{$employee->full_name}} </h1>
        </div>

        <div>
            @foreach ($employee->positions as $position)
                <div class="block mt-2 py-2">
                    {{ $position->name}}
                </div>
            @endforeach
        </div>
        <hr>
{{--        <div>--}}
{{--            @foreach ($employee->trainings as $training)--}}
{{--                <div class="flex content-between flex-wrap" >--}}

{{--                    <div class="w-3/6  block mt-2 py-2">--}}
{{--                        {{ $training->name}}--}}
{{--                    </div>--}}
{{--                    <div class="w-1/6 text-center justify-center md:justify-end  block mt-2 py-2">--}}
{{--                        ({{\App\Certificate::all()->where('training_id', $training->id)->max('training_date')}})--}}
{{--                         --}}
{{--                    </div>--}}
{{--                    <div class="w-1/6 text-center justify-center md:justify-end  block mt-2 py-2"> --}}
{{--                         {{\App\Certificate::all()->where('training_id', $training->id)->max('training_date')}}--}}
{{--                    </div>--}}
{{--                    <div class="w-1/6 text-center justify-center md:justify-end  block mt-2 py-2">--}}
{{--                         {{\App\Certificate::all()->where('training_id', $training->id)->max('expiry_date')}}--}}
{{--                    @foreach ($training->certificates as $certificate){{ $certificate->training_date}} {{ $certificate->expiry_date}} @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}


        <div>

            @foreach ($employee->trainings as $training)
                <div class="flex content-between flex-wrap" >

                        <div class="w-4/6  block mt-2 py-2">
                            {{ $training->name}}
                        </div>
                @foreach ($employee->certificates->where('training_id', $training->id)->sortByDesc('training_date') as $certificate)

                        @if($loop->first)
                            <div class="w-1/6  text-right block mt-2 py-2">
                                {{ $certificate->training_date}}
                            </div>

                            <div class="w-1/6 text-right block mt-2 py-2">
                                @if(  Carbon\Carbon::now()->subDays(30) > $certificate->expiry_date)
                                    <svg class="inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M15 19a3 3 0 0 1-6 0H4a1 1 0 0 1 0-2h1v-6a7 7 0 0 1 4.02-6.34 3 3 0 0 1 5.96 0A7 7 0 0 1 19 11v6h1a1 1 0 0 1 0 2h-5zm-4 0a1 1 0 0 0 2 0h-2zm0-12.9A5 5 0 0 0 7 11v6h10v-6a5 5 0 0 0-4-4.9V5a1 1 0 0 0-2 0v1.1z"/></svg>
                                @endif {{ $certificate->expiry_date}}
                            </div>


                        @endif



                @endforeach
                </div>
            @endforeach
        </div>


































    </div>

@endsection
