<div>
    <label for="name" class="block mt-2 py-2">Department Name:</label>
    <input type="text" name="name" value="{{old('name', $position->name)  }}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
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
    <label for="department_id" class="block mt-2 py-2">Dział:</label>
    <select name="department_id" id="department_id" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('department_id') ? 'is-invalid' : '' }}">
        @foreach ($departments as $department)
            @if (old('department_id') == $department->id)
                <option value="{{ $department->id }}" selected>{{$department->name}}</option>
            @else
                <option value="{{ $department->id }}" {{$department->id == $position->department_id ? 'selected' : ''}}>{{$department->name}}</option>
            @endif
        @endforeach
    </select>
</div>

























@csrf
