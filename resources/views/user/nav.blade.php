<div class="md:w-1/6">
    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
        Admin Panel
    </div>
    <ul class="">
        <li class="md:mr-6 mt-6">

            <a class="text-indigo-500 hover:text-red-800" href="{{ route('user.employees.index', ['company'=>$company->id ?? 'company'] ) }}">Employees</a>
        </li>
    </ul>
</div>







