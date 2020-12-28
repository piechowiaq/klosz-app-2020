@extends('layouts.app')
@section('content')
    @include('admin.nav')
    @php
        /**
        * @var App\User $user
        */
    @endphp
    <div class="md:w-5/6">
    <div class="block mt-2 py-2">
            <h1>{{$user->full_name}} </h1>
    </div>
    <hr>
    <div>
        @foreach ($user->getRoles() as $role)
            <div class="block mt-2 py-2">
                {{ $role->getName()}}
            </div>
        @endforeach
    </div>
    <hr>
    <div>
        @foreach ($user->getCompanies() as $company)
            <div class="block mt-2 py-2">
                {{ $company->getName()}}
            </div>
        @endforeach
    </div>
    </div>
@endsection
