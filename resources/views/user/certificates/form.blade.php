@php
    /**
    * @var Illuminate\Database\Eloquent\Collection | App\Training[] $companyTrainings
    * @var Illuminate\Database\Eloquent\Collection | App\Employee[] $companyEmployees
    * @var App\Certificate $certificate
    */
@endphp
<div>
    <label for="training_id" class="block mt-2 py-2">Szkolenie:</label>
    <select name="training_id" id="training_id"
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('employee_id') ? 'is-invalid' : '' }}">
        @foreach ($companyTrainings as $training)
            @if( old('training_id') === $training->getId())
                <option
                    value="{{ $training->getId()}}" selected>{{$training->getName()}}</option>
            @else
                <option
                    value="{{ $training->getId()}}" {{(isset($certificate) && $training->getId() === $certificate->getTraining()->getId()) ? 'selected' : ''}}>{{$training->getName()}}</option>
            @endif
        @endforeach
    </select>
</div>
<div>
    <label for="training_date" class="block mt-2 py-2">Data Szkolenia:</label>
    <input type="date" name="training_date" value="{{old('training_date', isset($certificate) ? $certificate->getTrainingDate()->format('Y-m-d') : '') }}"
           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('training_date') ? 'is-invalid' : '' }}">
</div>
<div>
    <label for="employee_id" class="block mt-2 py-2">Stanowisko Pracownika:</label>
    <select name="employee_id[]" id="employee_id"
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('employee_id') ? 'is-invalid' : '' }}"
            multiple="multiple">
        @foreach ($companyEmployees as $employee)
            <option value="{{$employee->getId()}}"
                {{ (isset($certificate) && in_array($employee->getId(), $certificate->getEmployees()->pluck('id')->toArray() ) ? 'selected': '' ) || in_array($employee->getId(), old('employee_id') ?: []) ? 'selected': '' }}
            >{{$employee->full_name}}</option>
        @endforeach
    </select>
</div>
<div>
    <label for="certificate_path" class="block mt-2 py-2">Kopia Certyfikatu:</label>
    <input type="file" name="file"
           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline">
</div>


@csrf
