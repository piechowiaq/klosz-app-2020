<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Http\Response
     */
    public function company()
    {
        $user = Auth::user();

        return view('home', compact('user'));
    }

    public function index($id)
    {
        $company = Company::findOrFail($id);

        return view('company', compact('company'));
    }

    public function employees($id)
    {
        $company = Company::findOrFail($id);

        $employees = Employee::where('company_id', $id)->get();

        return view('users.employees.index', compact('employees', 'company'));
    }
}
