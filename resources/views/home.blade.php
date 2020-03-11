@extends('layouts.app')

@section('content')
    <div class="flex items-center">
        <div class="container mx-auto items-center ">

            @if (session('status'))
                <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

                <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                    Dashboard
                </div>

                <div class="w-full p-6">


                    @foreach ($user->companies as $company)

                        <div class="md:flex border rounded shadow mb-1">

                            <div class="m-2 p-2 py-2 md:w-5/6 ">

                                <a href="{{route('company', ['company'=>$company->id])}}">{{ $company->name}}</a>


                            </div>



                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
