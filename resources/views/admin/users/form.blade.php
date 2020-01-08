<div>
    <label for="name" class="block mt-2 py-2">Imię:</label>
    <input type="text" name="name" value="{{old('name') ?? $user->name}}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
</div>

<div class="">
    <label for="surname" class="block mt-2 py-2">Nazwisko:</label>
    <input type="text" name="surname" value="{{old('surname') ?? $user->surname }}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('surname') ? 'is-invalid' : '' }}" required>
</div>

<div class="">
    <label for="email" class="block mt-2 py-2">Adres e-mail:</label>
    <input type="email" name="email" value="{{old('email') ?? $user->email}}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('email') ? 'is-invalid' : '' }}" required>
</div>

<div class="">
    <label for="role_id" class="block mt-2 py-2">Role:</label>
    <select name="role_id[]" id="role_id" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('role_id') ? 'is-invalid' : '' }}" multiple="multiple" >
        @foreach ($roles as $role)
            <option value="{{$role->id}}"{{in_array($role->id, old('role_id') ?: []) ? 'selected': '' || in_array($role->id, $user->roles()->pluck('role_id')->toArray() ) ? 'selected': '' }} >{{$role->name}}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="company_id" class="block mt-2 py-2">Company:</label>
    <select name="company_id[]" id="company_id" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('company_id') ? 'is-invalid' : '' }}" multiple="multiple" >
        @foreach ($companies as $company)
            <option value="{{$company->id}}"{{in_array($company->id, old('$company_id') ?: []) ? 'selected': '' || in_array($company->id, $user->companies()->pluck('company_id')->toArray() ) ? 'selected': '' }} >{{$company->name}}</option>
        @endforeach
    </select>
</div>

{{--<div class="form-group">--}}
{{--    <label for="active">Status pracownika:</label>--}}
{{--    <select name="active" id="active" class="form-control  {{ $errors->has('active') ? 'is-invalid' : '' }}" required>--}}
{{--        <option value="" disabled>Wybierz status pracownika</option>--}}
{{--        <option value="1" {{$employee->active == 1 ? 'selected' : ''}}>Aktywny</option>--}}
{{--        <option value="0" {{$employee->active == 0 ? 'selected' : ''}}>Nieaktywny</option>--}}
{{--    </select>--}}
{{--</div>--}}

@csrf
