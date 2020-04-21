<?php

namespace App\Http\Controllers\User;

use App\Company;
use App\Employee;
use App\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Charts\RegistryChart;
use App\Charts\TrainingChart;

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
        $registryChart->dataset('Registry Chart', 'doughnut', [90, 10])->options([
            'backgroundColor' =>  ['#48BB78'],
            'borderWidth' =>  0,
        ]);
        $registryChart->displayAxes(false);
        $registryChart->height(150);
        $registryChart->width(150);
        $registryChart->options([
            'circumference' => 1*pi(),
            'rotation' => 1*pi(),
        ]);

        $trainingChart = new TrainingChart;
        $trainingChart->dataset('Registry Chart', 'doughnut', [90, 10])->options([
            'backgroundColor' =>  ['#48BB78'],
            'borderWidth' =>  0,
        ]);
        $trainingChart->displayAxes(false);
        $trainingChart->height(150);
        $trainingChart->width(150);
        $trainingChart->options([
            'circumference' => 1*pi(),
            'rotation' => 1*pi(),
        ]);



        return view('user.dashboard', compact('company', 'registryChart', 'trainingChart'));
    }


}
