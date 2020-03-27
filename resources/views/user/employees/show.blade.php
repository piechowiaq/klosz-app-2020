@extends('layouts.app')

@section('content')

    @include('user.nav')

    <div class="md:w-5/6">

        <div class="block mt-2 py-2">
            <h1>{{$employee->full_name}} </h1>
        </div>
        <hr>
        <div>
            @foreach ($employee->departments as $department)
                <div class="block mt-2 py-2">
                    {{ $department->name}}
                </div>
            @endforeach
        </div>
        <hr>
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
                                    !
                                @endif {{ $certificate->expiry_date}}
                            </div>


                        @endif



                @endforeach
                </div>
            @endforeach
        </div>


































    </div>

@endsection
