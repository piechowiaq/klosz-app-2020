<div class="md:w-1/6">
    <div class="text-yellow-500 ">
      <h1 class="text-lg font-semibold">Menu</h1>
    </div>
    <ul class="">
        <li class="md:mr-6 mt-6">

            <a class="text-indigo-500 hover:text-indigo-800" href="{{ route('user.trainings.index', ['company'=>$company->id ?? 'company'] ) }}"><svg class="inline mr-4 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M11 20v-2.08a6 6 0 0 1-4.24-3A4.02 4.02 0 0 1 2 11V6c0-1.1.9-2 2-2h2c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2h2a2 2 0 0 1 2 2v5a4 4 0 0 1-4.76 3.93A6 6 0 0 1 13 17.92V20h4a1 1 0 0 1 0 2H7a1 1 0 0 1 0-2h4zm6.92-7H18a2 2 0 0 0 2-2V6h-2v6c0 .34-.03.67-.08 1zM6.08 13A6.04 6.04 0 0 1 6 12V6H4v5a2 2 0 0 0 2.08 2zM8 4v8a4 4 0 1 0 8 0V4H8z"/></svg> Szkolenia</a>
        </li>
        <li class="md:mr-6 mt-6">

            <a class="text-indigo-500 hover:text-indigo-800" href="{{ route('user.employees.index', ['company'=>$company->id ?? 'company'] ) }}"><svg class="inline mr-4 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M9 12A5 5 0 1 1 9 2a5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v2zm1-5a1 1 0 0 1 0-2 5 5 0 0 1 5 5v2a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3zm-2-4a1 1 0 0 1 0-2 3 3 0 0 0 0-6 1 1 0 0 1 0-2 5 5 0 0 1 0 10z"/></svg>Pracownicy</a>
        </li>

    </ul>
</div>




