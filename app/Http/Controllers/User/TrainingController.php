<?php

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Training;
use Carbon\Carbon;
use function GuzzleHttp\Promise\all;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $companyId
     * @param $trainingId
     * @param Certificate $certificate
     * @return \Illuminate\Http\Response
     */
    public function index($companyId, Certificate $certificate)
    {
        $company = Company::findOrfail($companyId);


        $companyTrainings =  $company->positions->flatMap(function($position){
            return $position->trainings;
        })->unique('id');


        return view('user.trainings.index', compact('companyTrainings', 'company', 'certificate', 'companyId'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show($companyId, Training $training)
    {
        $company = Company::findOrFail($companyId);

        $trainingEmployees = $training->employees->filter(function ($employee) use ($companyId) {

         return  $employee->company_id == $companyId;

        });

        return view('user.trainings.show', compact('training', 'company', 'trainingEmployees'));
    }


}
