@php
    /**
     * @var Illuminate\Database\Eloquent\Collection | App\Department[] $departments
     * @var Illuminate\Database\Eloquent\Collection | App\Registry[] $registries
     * @var App\Company $company
     */
@endphp

<div>
    <label for="name" class="block mt-2 py-2">Nazwa Firmy:</label>
    <input type="text" name="name" value="{{old('name', isset($company) ? $company->getName() : '') }}"
           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('name') ? 'is-invalid' : '' }}"
           required>
</div>

<div>
    <label for="department_ids" class="block mt-2 py-2">Dział:</label>
    @foreach ($departments as $department)
        <ol>
            <input type="checkbox" name="department_ids[]" id="department_ids"
                   class="mr-2 leading-tight {{ $errors->has('department_ids') ? 'is-invalid' : '' }}"
                   multiple="multiple"
                   value="{{$department->getId()}}" {{(in_array($department->getId(), isset($company) ? $company->getDepartments()->pluck('id')->toArray() : [] ) ? 'checked': '' )|| in_array($department->getId(), old('department_ids') ?: []) ? 'checked': ''  }}>
            <label>{{$department->getName()}}</label>
        </ol>
    @endforeach
</div>

<div>
    <label for="registry_ids" class="block mt-2 py-2">Rejestr:</label>
    @foreach ($registries as $registry)
        <ol>
            <input type="checkbox" name="registry_ids[]" id="registry_ids"
                   class="mr-2 leading-tight {{ $errors->has('registry_ids') ? 'is-invalid' : '' }}" multiple="multiple"
                   value="{{$registry->getId()}}" {{(in_array($registry->getId(), isset($company) ? $company->getRegistries()->pluck('id')->toArray() : [] ) ? 'checked': '' )|| in_array($registry->getId(), old('registry_ids') ?: []) ? 'checked': ''  }}>
            <label>{{$registry->getName()}}</label>
        </ol>
    @endforeach
</div>

@csrf
