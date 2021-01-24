@extends('layouts.app')
@section('content')
    @include('admin.nav')
    @php
        /**
        * @var App\Company $company
        */
    @endphp
    <div class="md:w-5/6">
        <div class="block mt-2 py-2">
            <h1>{{$company->getName()}} </h1>
        </div>
        <hr>
        <div>
            <label class="block mt-2 py-2">Użytkownicy:</label>
            @foreach ($company->getUsers() as $user)
                <div class="block mt-2 py-2 text-gray-600">
                    {{ $user->full_name}}
                </div>
            @endforeach
        </div>
        <hr>
        <div>
            <label class="block mt-2 py-2">Pozycje:</label>
            @foreach ($company->getPositions() as $position)
                <div class="block mt-2 py-2 text-gray-600">
                    {{ $position->getName()}}
                </div>
            @endforeach
        </div>
        <hr>
        <div>
            <label class="block mt-2 py-2">Działy:</label>
            @foreach ($company->getDepartments() as $department)
                <div class="block mt-2 py-2 text-gray-600">
                    {{ $department->getName()}}
                </div>
            @endforeach

        </div>
        <hr>
        <div>
            <label class="block mt-2 py-2">Szkolenia:</label>
            @foreach ($company->getTrainings() as $training)
                <div class="block mt-2 py-2 text-gray-600">
                    {{ $training->getName()}}
                </div>
            @endforeach
        </div>
        <hr>
        <div>
            <label class="block mt-2 py-2">Rejestry:</label>
            @foreach ($company->getRegistries() as $registry)
                <div class="block mt-2 py-2 text-gray-600">
                    {{ $registry->getName()}}
                </div>
            @endforeach
        </div>
    </div>
@endsection
