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

        return view('user.trainings.index', compact('companyTrainings', 'company', 'certificate'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show($companyId, Training $training)
    {




        //$this->authorize('update', $training);

 //       $validCertifiactes = $certificates->filter(function ($cetificate){
//            return $certificate->expiry_date > Carbon::now();
//        });
//
//        foreach ($validCertifiactes as $certificate){
//$
//
//
//        }
//        $collection = collect();
//        foreach ($training->employees as $employee){
//            foreach ($employee->certificates as $certificate) {
//                $collection[] = $certificate;
//            }}
//        dd($collection->where('expiry_date', '>', Carbon::now() )->where('training_id', $training->id)->count());
//        dd($certificates = $employees->certificates());

//                ->where('training_id', $training->id)->sortByDesc('training_date')->count();

    //$training->certificates()->with('employees')->where('expiry_date','>', Carbon::now());
        $company = Company::findOrFail($companyId);

        return view('user.trainings.show', compact('training', 'company'));
    }


}
