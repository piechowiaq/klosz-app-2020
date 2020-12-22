@php
    /**
     * @var App\Training $training
     * @var Illuminate\Database\Eloquent\Collection | App\Position[] $positions
     */
@endphp
<div>
    <label for="name" class="block mt-2 py-2">Nazwa Szkolenia:</label>
    <input type="text" name="name" value="{{old('name',  isset($training) ? $training->getName() : '') }}"
           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('name') ? 'is-invalid' : '' }}"
           required>
</div>
<div>
    <label for="description">Opis szkolenia:</label>
    <textarea type="text" name="description" rows="3"
              class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('description') ? 'is-invalid' : '' }}">{{old('description', isset($training) ? $training->getDescription() : '') }}</textarea>
</div>
<div>
    <label for="valid_for">Ważne przez okres:</label>
    <input type="number" name="valid_for" value="{{old('valid_for', isset($training) ? $training->getValidFor() : '')}}"
           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('valid-for') ? 'is-invalid' : '' }}">
</div>
<div>
    <label for="position_id">Funkcja:</label>
    <select name="position_id[]" id="position_id"
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('position_id') ? 'is-invalid' : '' }}"
            multiple="multiple">
        @foreach ($positions as $position)
            <option
                value="{{$position->getID()}}"{{(isset($training) && in_array($position->getID(), $training->getPositions()->pluck('id')->toArray() ) ? 'selected': '')||in_array($position->getID(), old('position_id') ?: []) ? 'selected': ''  }} >{{$position->getName()}}</option>
        @endforeach
    </select>
</div>


@csrf
