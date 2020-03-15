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
        <div>
            @foreach ($employee->trainings as $training)
                <div class="block mt-2 py-2">
                    {{ $training->name}}
                </div>
            @endforeach
        </div>
    </div>

@endsection
