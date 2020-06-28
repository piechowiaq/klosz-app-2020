@extends('layouts.app')

@section('content')
    <div class="flex mx-auto items-center">
        <div class="container  ">

            @if (session('status'))
                <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif


            <div class="container mx-auto px-6 flex  ">

                    <div class="m-2 p-2 text-center text-lg md:text-6xl font-semibold text-gray-500 no-underline">

                        <p>  Welcome to <span class="text-yellow-500">Klosz</span> </p>


                        <p class="text-sm text-gray-400 mt-4"> Aplikacja do zarządzania <span class="text-yellow-400">PPOŻ, HACCP, BHP</span> dla obiektów hotelowych i lokali gastronomicznych</p>

                    </div>



            </div>
        </div>
    </div>
@endsection
