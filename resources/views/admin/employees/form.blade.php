<div>
    <label for="name" class="block mt-2 py-2">Imię:</label>
    <input type="text" name="name" value="{{old('name') ?? $employee->name}}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('name') ? 'is-invalid' : '' }}" >
</div>

<div>
    <label for="surname" class="block mt-2 py-2">Nazwisko:</label>
    <input type="text" name="surname" value="{{old('surname') ?? $employee->surname }}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('surname') ? 'is-invalid' : '' }}" >
</div>

<div>
    <label for="number">Numer Pracownika:</label>
    <input type="number" name="number" value="{{old('number') ?? $employee->number}}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('valid-for') ? 'is-invalid' : '' }}">
</div>

<div>
    <label for="position_id" class="block mt-2 py-2">Funkcja:</label>
    <select name="position_id[]" id="position_id" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('position_id') ? 'is-invalid' : '' }}" multiple="multiple" >
        @foreach ($positions as $position)
            <option value="{{$position->id}}"{{in_array($position->id, old('position_id') ?: []) ? 'selected': '' || in_array($position->id, $employee->positions()->pluck('position_id')->toArray() ) ? 'selected': '' }} >{{$position->name}}</option>
        @endforeach
    </select>
</div>

<div>
    <label for="company_id" class="block mt-2 py-2">Company:</label>
    <select name="company_id" id="company_id" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('company_id') ? 'is-invalid' : '' }}"  >
        @foreach ($companies as $company)
            <option value="{{$company->id}}"{{in_array($company->id, old('company_id') ?: []) ? 'selected': '' || in_array($company->id, $employee->company()->pluck('company_id')->toArray() ) ? 'selected': '' }} >{{$company->name}}</option>
        @endforeach
    </select>
</div>

{{--<div class="form-group">--}}
{{--    <label for="active">Status pracownika:</label>--}}
{{--    <select name="active" id="active" class="form-control  {{ $errors->has('active') ? 'is-invalid' : '' }}" required>--}}
{{--        <option value="" disabled>Wybierz status pracownika</option>--}}
{{--        <option value="1" {{$employee->active == 1 ? 'selected' : ''}}>Aktywny</option>--}}
{{--        <option value="0" {{$employee->active == 0 ? 'selected' : ''}}>Nieaktywny</option>--}}
{{--    </select>--}}
{{--</div>--}}

@csrf
