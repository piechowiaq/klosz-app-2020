@extends('layouts.app')
@section('content')
    @include('admin.nav')
    @php
        /**
        * @var App\Registry $registry
        */
    @endphp
    <div class="md:w-5/6">
        <div class="block mt-2 py-2">
            <h1>{{$registry->getName()}} </h1>
        </div>
        <hr>
    </div>
@endsection
