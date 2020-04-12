<?php

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Http\Controllers\Controller;
use App\Registry;
use App\Report;
use Illuminate\Http\Request;

class RegistryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($companyId, Report $report)
    {
        $company = Company::findOrfail($companyId);

        $companyRegistries =  $company->registries;

        return view('user.registries.index', compact('companyRegistries', 'company', 'report'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Registry  $registry
     * @return \Illuminate\Http\Response
     */
    public function show($companyId, Registry $registry, Report $report)
    {
        $company = Company::findOrFail($companyId);

        return view('user.registries.show', compact('registry', 'company', 'report'));
    }

}
