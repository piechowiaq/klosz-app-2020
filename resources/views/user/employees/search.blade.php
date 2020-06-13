@extends('layouts.app')

@section('content')
    @include('user.nav')
    <div class="md:w-5/6 md:m-0 m-2">

            <div class="flex justify-between py-6 m-2 md:py-2">
                @can('update', $employee)
                     <div class="">
                         <a href="{{route('user.employees.create', ['company'=>$company])}}" class="rounded border text-indigo-500 p-2 bg-transparent" >Dodaj Pracownika</a>
                     </div>
                @endcan
            </div>
                    <div class="flex italic text-gray-700">
                        <search>





                        </search>
                    </div>



    </div>




@endsection
