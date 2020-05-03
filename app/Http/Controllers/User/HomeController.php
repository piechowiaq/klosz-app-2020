<?php

namespace App\Http\Controllers\User;

use App\Company;
use App\Employee;
use App\Training;
use Carbon\Carbon;
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

        $companyTrainings =  $company->positions->flatMap(function($position){
            return $position->trainings;
        })->unique('id');

        $collection = collect([]);

        foreach ($companyTrainings as $training) {

            $collection->push( $training->employees->where('company_id', $companyId)->count() == 0 ?0: round($training->employees()->certified($training, $companyId)->count() / $training->employees->where('company_id', $companyId)->count() * 100));
        }

        $average = round ($collection->avg());



        $companyRegistries = $company->registries;

        $collection = collect();

        foreach($company->registries as $registry) {
            foreach($registry->reports as $report) {
                   if($report->expiry_date > now()){
                $collection->push($report);

            }}}


        $validRegistries = $collection->unique('registry_id')->count();

        $registryChartValue= $companyRegistries->count() ==0 ?0: round($validRegistries / $companyRegistries->count()*100);


        return view('user.dashboard', compact('company', 'companyTrainings' , 'average', 'companyRegistries', 'registryChartValue'));
    }


}
