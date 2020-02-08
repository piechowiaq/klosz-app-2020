<div>
    <label for="name" class="block mt-2 py-2">Nazwa Szkolenia:</label>
    <input type="text" name="name" value="{{old('name') ?? $training->name}}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
</div>

{{--<div class="form-group">--}}
{{--    <label for="active">Status pracownika:</label>--}}
{{--    <select name="active" id="active" class="form-control  {{ $errors->has('active') ? 'is-invalid' : '' }}" required>--}}
{{--        <option value="" disabled>Wybierz status pracownika</option>--}}
{{--        <option value="1" {{$employee->active == 1 ? 'selected' : ''}}>Aktywny</option>--}}
{{--        <option value="0" {{$employee->active == 0 ? 'selected' : ''}}>Nieaktywny</option>--}}
{{--    </select>--}}
{{--</div>--}}


<div>
    <label for="description">Opis szkolenia:</label>
    <textarea type="text" name="description" rows="3" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('description') ? 'is-invalid' : '' }}">{{old('description') ?? $training->description }}</textarea>
</div>

<div>
    <label for="valid_for">Ważne przez okres:</label>
    <input type="number" name="valid_for" value="{{old('valid_for') ?? $training->valid_for}}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('valid-for') ? 'is-invalid' : '' }}">
</div>

<div>
    <label for="position_id">Funkcja:</label>
    <select name="position_id[]" id="position_id" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('position_id') ? 'is-invalid' : '' }}" multiple="multiple" >
        @foreach ($positions as $position)
            <option value="{{$position->id}}"{{in_array($position->id, old('position_id') ?: []) ? 'selected': '' || in_array($position->id, $training->positions()->pluck('position_id')->toArray() ) ? 'selected': '' }} >{{$position->name}}</option>
        @endforeach
    </select>
</div>






















@csrf
