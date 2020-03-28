<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function company()
    {
        $user = Auth::user();

        if($user->companies()->count() == 1){

            $company = $user->companies()->first();

            $companyId = $company->id;

//            return view('user.home', compact('company'));

            return Redirect::action('HomeController@index', $companyId);

        }
        else if($user->isSuperAdmin()){

            return Redirect::action('AdminController@index');

        }
        else {

            return view('home', compact('user'));

        }

    }

    public function index($companyId)
    {
        $company = Company::findOrFail($companyId);

        return view('user.home', compact('company'));
    }


}
