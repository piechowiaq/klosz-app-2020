@php
    /**
     * @var \App\User $user
     * @var Illuminate\Database\Eloquent\Collection |App\Company[] $companies
     * @var Illuminate\Database\Eloquent\Collection |App\Role[] $roles
     */
@endphp
<div>
    <label for="name" class="block mt-2 py-2">Imię:</label>
    <input type="text" name="name" value="{{old('name', isset($user) ? $user->getName() : '')}}"
           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('name') ? 'is-invalid' : '' }}">
</div>
<div>
    <label for="surname" class="block mt-2 py-2">Nazwisko:</label>
    <input type="text" name="surname" value="{{old('surname', isset($user) ? $user->getSurname() : '')}}"
           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('surname') ? 'is-invalid' : '' }}">
</div>
<div>
    <label for="email" class="block mt-2 py-2">Adres e-mail:</label>
    <input type="email" name="email" value="{{old('email', isset($user) ? $user->getEmail() : '' )}}"
           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('email') ? 'is-invalid' : '' }}">
</div>
<div>
    <label for="password" class="block mt-2 py-2">Hasło:</label>
    <input type="password" name="password" value="{{old('password')}}"
           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('password') ? 'is-invalid' : '' }}">
</div>
<div>
    <label for="role_id" class="block mt-2 py-2">Role:</label>
    <select name="role_id[]" id="role_id"
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('role_id') ? 'is-invalid' : '' }}"
            multiple="multiple">
        @foreach ($roles as $role)
            <option
                value="{{$role->getId()}}" {{(isset($user) && in_array($role->getId(), $user->getRoles()->pluck('id')->toArray() ) ? 'selected': '') || in_array($role->getID(), old('role_id') ?: []) ? 'selected': '' }} >{{$role->getName()}}</option>
        @endforeach
    </select>
</div>
<div>
    <label for="company_id" class="block mt-2 py-2">Company:</label>
    <select name="company_id[]" id="company_id"
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('company_id') ? 'is-invalid' : '' }}"
            multiple="multiple">
        @foreach ($companies as $company)
            <option
                value="{{$company->getId()}}" {{(isset($user) && in_array($company->getId(), $user->getCompanies()->pluck('id')->toArray() ) ? 'selected': '') || in_array($company->getId(), old('$company_id') ?: []) ? 'selected': ''}}>{{$company->getName()}}</option>
        @endforeach
    </select>
</div>
@csrf
