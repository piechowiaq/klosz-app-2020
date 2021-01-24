@extends('layouts.app')
@section('content')
    @include('admin.nav')
    @php
        /**
        * @var Illuminate\Database\Eloquent\Collection | App\Department[] $departments
        * @var App\Department $department
        */
    @endphp
    <div class="md:w-5/6">
        <div class="block mt-2 py-2">
            <h1>{{$department->getName()}} </h1>
        </div>
        <hr>
        <div>
            @foreach ($department->getPositions() as $position)
                <div class="block mt-2 py-2">
                    {{ $position->getName()}}
                </div>
            @endforeach
        </div>
    </div>
@endsection
