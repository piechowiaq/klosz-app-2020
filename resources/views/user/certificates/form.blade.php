

<div>
    <label for="training_id" class="block mt-2 py-2">Training:</label>
    <select name="training_id" id="training_id">
        @foreach ($trainings as $training)
            <option value="{{$training->id}}" {{$certificate->training_id == $training->id ? 'selected' : ''}}>{{$training->name}}</option>
        @endforeach
    </select>

</div>

<div>
    <label for="training_date">Data Szkolenia:</label>

        <input type="date" name="training_date" value="{{old('training_date') ?? $certificate->training_date}}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('training_date') ? 'is-invalid' : '' }}">

</div>










@csrf
