@extends('layouts.app')

@section('content')






    @include('users.nav')
    <div class="md:w-5/6">
        <h1 class="text-gray-600 text-center font-light tracking-wider text-5xl mb-6">
            {{ config('app.name', 'Klosz') }}
        </h1>
    </div>





{{--    <div class="min-h-screen flex items-center justify-center">--}}

{{--                --}}
{{--    </div>--}}

@endsection

