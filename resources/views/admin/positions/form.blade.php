@php
/**
 * @var App\Position $position
 * @var Illuminate\Database\Eloquent\Collection | App\Department[] $departments
 */
@endphp
<div>
    <label for="name" class="block mt-2 py-2">Department Name:</label>
    <input type="text" name="name" value="{{old('name', isset($position) ? $position->getName(): '')  }}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
</div>
<div>
    <label for="department_id" class="block mt-2 py-2">Dział:</label>
    <select name="department_id" id="department_id" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('department_id') ? 'is-invalid' : '' }}">
        @foreach ($departments as $department)
            @if (old('department_id') === $department->getId())
                <option value="{{ $department->getId() }}" selected>{{$department->getName()}}</option>
            @else
                <option value="{{ $department->getId() }}" {{(isset($position) && $department->getId() === $position->getDepartment()->getId()) ? 'selected' : ''}}>{{$department->getName()}}</option>
            @endif
        @endforeach
    </select>
</div>























@csrf
