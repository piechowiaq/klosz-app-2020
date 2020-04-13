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
                <div class="flex flex-wrap justify-center">
                    <div class="w-full max-w-sm flex flex-col break-words bg-white  ">
                        <h1 class="font-semibold bg-gray-200 text-yellow-500 text-center py-3 px-6 mb-0">Wybierz Firmę</h1>
                    </div>
                </div>
                <div class="w-full p-6 ">
                    @foreach ($user->companies as $company)
                        <div class="md:flex border mb-1">
                            <div class="m-2 p-2 py-2 ">
                                <a href="{{route('user.dashboard', ['company'=>$company->id])}}">{{ $company->name}}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
