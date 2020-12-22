@extends('layouts.app')
@section('content')
    @include('admin.nav')
    <div class="md:w-5/6">
        <div class="">
            <div><h1>Create Training</h1></div>
            <div>
                <form action="{{route('admin.trainings.store')}}" method="POST">
                    @include('admin.trainings.form')
                    <button type="submit"
                            class="p-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded mt-4 ">
                        Add Training
                    </button>
                    @include('errors')
                </form>
            </div>
        </div>
    </div>
@endsection
