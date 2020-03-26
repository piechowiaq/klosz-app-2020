<div>
    <label for="name" class="block mt-2 py-2">Nazwa Certifikatu:</label>
    <input type="text" name="name" value="{{old('name') ?? $certificate->name}}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
</div>

<div>
    <label for="training_id" class="block mt-2 py-2">Training:</label>
    <select name="training_id" id="training_id">
        @foreach ($trainings as $training)
            <option value="{{$training->id}}" {{$certificate->training_id == $training->id ? 'selected' : ''}}>{{$training->name}}</option>
        @endforeach
    </select>

</div>
<div>
    <label for="company_id" class="block mt-2 py-2">Firma:</label>
    <select name="company_id" id="company_id">
        @foreach ($companies as $company)
            <option value="{{$company->id}}" {{$certificate->company_id == $company->id ? 'selected' : ''}}>{{$company->name}}</option>
        @endforeach
    </select>
</div>
<div>
    <label for="training_date">Data Szkolenia:</label>

        <input type="date" name="training_date" value="{{old('training_date') ?? $certificate->training_date}}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('training_date') ? 'is-invalid' : '' }}">

</div>










@csrf
