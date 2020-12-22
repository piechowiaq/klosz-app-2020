@php
    /**
    * @var App\Registry $registry
    */
@endphp

<div>
    <label for="name" class="block mt-2 py-2">Nazwa Szkolenia:</label>
    <input type="text" name="name" value="{{old('name',  isset($registry) ? $registry->getName() : '') }}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
</div>
<div>
    <label for="description">Opis Rejestru:</label>
    <textarea type="text" name="description" rows="3" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('description') ? 'is-invalid' : '' }}">{{old('description', isset($registry) ? $registry->getDescription() : '') }}</textarea>
</div>

<div>
    <label for="valid_for">Ważne przez okres:</label>
    <input type="number" name="valid_for" value="{{old('valid_for', isset($registry) ? $registry->getValidFor() : '')}}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('valid-for') ? 'is-invalid' : '' }}">
</div>
























@csrf
