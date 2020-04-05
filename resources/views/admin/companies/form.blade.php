<div>
    <label for="name" class="block mt-2 py-2">Nazwa Firmy:</label>
    <input type="text" name="name" value="{{old('name', $company->name) }}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
</div>

<div>
    <label for="department_id" class="block mt-2 py-2">Dział:</label>
    @foreach ($departments as $department)
        <ol>
            <input type="checkbox" name="department_id[]" id="department_id" class="mr-2 leading-tight {{ $errors->has('department_id') ? 'is-invalid' : '' }}" multiple="multiple" value="{{$department->id}}" {{(in_array($department->id, $company->departments()->pluck('department_id')->toArray() ) ? 'checked': '' )|| in_array($department->id, old('department_id') ?: []) ? 'checked': ''  }}>
            <label  >{{$department->name}}</label>
        </ol>
    @endforeach
</div>

@csrf
