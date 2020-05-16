

<div>
    <label for="registry_id" class="block mt-2 py-2">Szkolenie:</label>
    <select name="registry_id" id="registry_id" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline {{ $errors->has('registry_id') ? 'is-invalid' : '' }}" >
        @foreach ($company->registries as $registry)
            <option value="{{$registry->id}}" {{$report->registry_id == $registry->id ? 'selected' : ''}}>{{$registry->name}}</option>
        @endforeach
    </select>

</div>

<div>
    <label for="report_date" class="block mt-2 py-2">Data Raportu:</label>

        <input type="date" name="report_date" value="{{old('report_date', $report->report_date) }}" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline  {{ $errors->has('report_date') ? 'is-invalid' : '' }}">

</div>

<div>
    <label for="report_path" class="block mt-2 py-2">Kopia Raportu:</label>

    <input type="file" name="report_path" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500 focus:shadow-outline">

</div>









@csrf
