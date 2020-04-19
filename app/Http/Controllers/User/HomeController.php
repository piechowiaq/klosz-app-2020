<?php

namespace App\Http\Controllers\User;

use App\Company;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Charts\RegistryChart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function home()
    {
        $user = Auth::user();



        if($user->companies()->count() == 1){

            $company = $user->companies()->first();

            $companyId = $company->id;


            return Redirect::action('User\HomeController@index', $companyId);

        }
        else if($user->isSuperAdmin()){

            return Redirect::action('Admin\AdminController@index');

        }
        else {

            return view('user.home', compact('user'));

        }

    }

    public function index($companyId)
    {
        $company = Company::findOrFail($companyId);

        $registryChart = new RegistryChart;
        $registryChart->labels(['Nieaktulane', 'Aktualne']);
        $registryChart->dataset('My dataset', 'doughnut', [1, 2]);
        $registryChart->minimalist(true);



        return view('user.dashboard', compact('company', 'registryChart'));
    }


}
