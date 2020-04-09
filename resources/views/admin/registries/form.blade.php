<div>
    <label for="name" class="block mt-2 py-2">Nazwa Szkolenia:</label>
    <input type="text" name="name" value="{{old('name',  $registry->name) }}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
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
    <label for="description">Opis Rejestru:</label>
    <textarea type="text" name="description" rows="3" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('description') ? 'is-invalid' : '' }}">{{old('description') ?? $registry->description }}</textarea>
</div>

<div>
    <label for="valid_for">Ważne przez okres:</label>
    <input type="number" name="valid_for" value="{{old('valid_for') ?? $registry->valid_for}}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('valid-for') ? 'is-invalid' : '' }}">
</div>
























@csrf
