<div xmlns:wire="http://www.w3.org/1999/xhtml">


    <input wire:model="search" type="search" placeholder="Szukaj pracowników"/>


    @foreach ($employees as $employee)

                <div class="md:flex border   mb-1">

                    <div class="m-2 p-2 py-2 md:w-5/6 ">

                        <a href="{{route('user.employees.show', ['employee'=> $employee, 'company'=>$company->id])}}">{{ $employee->full_name}}</a>

                    </div>

                    <div class="flex  justify-center md:justify-end md:w-1/6 ">
                        @can('update', $employee)
                        <div class=" px-2 bg-transparent hover:bg-blue-500 text-black-700 hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">
                            <a href="{{route('user.employees.edit', ['employee'=> $employee, 'company'=>$company])}}" class="">Edytuj</a>
                        </div>
                        @endcan
                        @can('update', $employee)
                        <div class="px-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">

                            <form action="{{route('user.employees.destroy', ['employee'=> $employee, 'company'=>$company])}}" method="POST">

                                @method('DELETE')

                                @csrf

                                <button type="submit" class="">Usuń</button>

                            </form>

                        </div>

                         @endcan
                    </div>

                </div>

            @endforeach






</div>
