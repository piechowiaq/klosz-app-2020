@extends('layouts.app')
@section('content')
    @include('admin.nav')
    @php
        /**
        * @var App\Position $position
        */
    @endphp
    <div class="md:w-5/6">
        <div class="block mt-2 py-2">
            <h1>{{$position->getName()}} </h1>
        </div>
        <hr>
        <div>
            @foreach ($position->getTrainings() as $training)
                <div class="block mt-2 py-2">
                    {{ $training->getName()}}
                </div>
            @endforeach
        </div>
    </div>
@endsection
