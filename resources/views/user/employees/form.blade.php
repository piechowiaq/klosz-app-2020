@php
    /**
    * @var App\Employee $employee
    * @var Illuminate\Database\Eloquent\Collection | App\Position[] $positions
    */
@endphp
<div>
    <label for="name" class="block mt-2 py-2">Imię:</label>
    <input type="text" name="name" value="{{old('name', isset($employee) ? $employee->getName() : '')}}"
           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('name') ? 'is-invalid' : '' }}">
</div>

<div>
    <label for="surname" class="block mt-2 py-2">Nazwisko:</label>
    <input type="text" name="surname" value="{{old('surname', isset($employee) ? $employee->getSurname() : '')}}"
           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('surname') ? 'is-invalid' : '' }}">
</div>

<div>
    <label for="number" class="block mt-2 py-2">Numer Pracownika:</label>
    <input type="number" name="number" value="{{old('number', isset($employee) ? $employee->getNumber() : '')}}"
           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('valid-for') ? 'is-invalid' : '' }}">
</div>

<div>
    <label for="position_ids" class="block mt-2 py-2">Funkcja:</label>
    <select name="position_ids[]" id="position_ids"
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('position_ids') ? 'is-invalid' : '' }}"
            multiple="multiple">
        @foreach ($positions as $position)
            <option
                value="{{$position->getId()}}" {{(isset($employee) && in_array($position->getId(), $employee->getPositions()->pluck('id')->toArray() ) ? 'selected': '' )|| in_array($position->getId(), old('position_ids')?:[])?'selected':''}} >{{$position->getName()}}</option>

        @endforeach
    </select>
</div>
@csrf
