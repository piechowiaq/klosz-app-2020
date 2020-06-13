<div class="md:w-1/6 text-center md:text-left ">
    <div class="mb-4">
        <h1 class="text-xs text-indigo-500 font-semibold">{{$company->name}}</h1>
    </div>

    <div class="text-yellow-500">
        <h1 class="text-lg font-semibold">Menu</h1>
    </div>
    <ul class="">
        <li class="md:mr-6 mt-6">
            <a class="text-indigo-500 hover:text-indigo-800" href="{{ route('user.dashboard', ['company'=>$company->id ?? 'company']) }}" ><svg class=" hidden md:inline-block  mr-4  " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm-5.6-4.29a9.95 9.95 0 0 1 11.2 0 8 8 0 1 0-11.2 0zm6.12-7.64l3.02-3.02 1.41 1.41-3.02 3.02a2 2 0 1 1-1.41-1.41z"/></svg>Dashboard</a>
        </li>
        <li class="md:mr-6 mt-6">
            <a class="text-indigo-500 hover:text-indigo-800" href="{{ route('user.registries.index', ['company'=>$company->id ?? 'company'] ) }}" ><svg class="hidden md:inline-block  mr-4 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M7.03 2.6a3 3 0 0 1 5.94 0L15 3v1h1a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h1V3l2.03-.4zM5 6H4v12h12V6h-1v1H5V6zm5-2a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>Rejestr</a>
        </li>
        <li class="md:mr-6 mt-6">
            <a class="text-indigo-500 hover:text-indigo-800" href="{{ route('user.trainings.index', ['company'=>$company->id ?? 'company'] ) }}"><svg class="hidden md:inline-block mr-4 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M11 20v-2.08a6 6 0 0 1-4.24-3A4.02 4.02 0 0 1 2 11V6c0-1.1.9-2 2-2h2c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2h2a2 2 0 0 1 2 2v5a4 4 0 0 1-4.76 3.93A6 6 0 0 1 13 17.92V20h4a1 1 0 0 1 0 2H7a1 1 0 0 1 0-2h4zm6.92-7H18a2 2 0 0 0 2-2V6h-2v6c0 .34-.03.67-.08 1zM6.08 13A6.04 6.04 0 0 1 6 12V6H4v5a2 2 0 0 0 2.08 2zM8 4v8a4 4 0 1 0 8 0V4H8z"/></svg> Szkolenia</a>
        </li>
        <li class="md:mr-6 mt-6">
            <a class="text-indigo-500 hover:text-indigo-800" href="{{ route('user.employees.index', ['company'=>$company->id ?? 'company'] ) }}"><svg class="hidden md:inline-block mr-4 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M9 12A5 5 0 1 1 9 2a5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v2zm1-5a1 1 0 0 1 0-2 5 5 0 0 1 5 5v2a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3zm-2-4a1 1 0 0 1 0-2 3 3 0 0 0 0-6 1 1 0 0 1 0-2 5 5 0 0 1 0 10z"/></svg>Pracownicy</a>
        </li>

{{--        <li class="md:mr-6 mt-6">--}}

{{--            <a class="text-indigo-500 hover:text-indigo-800" ><svg class="inline mr-4 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M0 4c0-1.1.9-2 2-2h7l2 2h7a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2 2v10h16V6H2z"/></svg>Audyty</a>--}}
{{--        </li>--}}
{{--        <li class="md:mr-6 mt-6">--}}

{{--            <a class="text-indigo-500 hover:text-indigo-800" ><svg class="inline mr-4 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M0 4c0-1.1.9-2 2-2h7l2 2h7a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4z"/></svg>Dokumenty</a>--}}
{{--        </li>--}}

@can('view', $user)
        <li class="md:mr-6 mt-6">
            <a class="text-indigo-500 hover:text-indigo-800" href="{{ route('user.home') }}"><svg class="hidden md:inline-block mr-4 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M18 9.87V20H2V9.87a4.25 4.25 0 0 0 3-.38V14h10V9.5a4.26 4.26 0 0 0 3 .37zM3 0h4l-.67 6.03A3.43 3.43 0 0 1 3 9C1.34 9 .42 7.73.95 6.15L3 0zm5 0h4l.7 6.3c.17 1.5-.91 2.7-2.42 2.7h-.56A2.38 2.38 0 0 1 7.3 6.3L8 0zm5 0h4l2.05 6.15C19.58 7.73 18.65 9 17 9a3.42 3.42 0 0 1-3.33-2.97L13 0z"/></svg>Obiekty</a>
        </li>
@endcan
    </ul>
</div>




