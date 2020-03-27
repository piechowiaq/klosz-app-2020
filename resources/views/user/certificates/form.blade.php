

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

<div>
    <label for="employee_id">Funkcja:</label>
    <select name="employee_id[]" id="employee_id" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('employee_id') ? 'is-invalid' : '' }}" multiple="multiple" >
        @foreach ($employees as $employee)
            <option value="{{$employee->id}}"{{in_array($employee->id, old('employee_id') ?: []) ? 'selected': '' || in_array($employee->id, $certificate->employees()->pluck('employee_id')->toArray() ) ? 'selected': '' }} >{{$employee->full_name}}</option>
        @endforeach
    </select>
</div>










@csrf
