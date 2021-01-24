@extends('layouts.app')
@section('content')
    @include('admin.nav')
    @php
        /**
        * @var App\Training $training
        */
    @endphp
    <div class="md:w-5/6">
        <div class="block mt-2 py-2">
            <h1>{{$training->getName()}} </h1>
        </div>
        <hr>
        <div>
            @foreach ($training->getPositions() as $position)
                <div class="block mt-2 py-2">
                    {{ $position->getName()}}
                </div>
            @endforeach
        </div>
    </div>
@endsection
