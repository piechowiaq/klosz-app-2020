@extends('layouts.app')

@section('content')
    <div class="flex mx-auto items-center">
        <div class="container  ">

            @if (session('status'))
                <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif


            <div class="container mx-auto px-6 md:px-0">

                Nie używane !! Welcome to Klosz

            </div>
        </div>
    </div>
@endsection
