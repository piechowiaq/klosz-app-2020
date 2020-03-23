<?php

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Http\Controllers\Controller;
use App\Training;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $companyId
     * @param Training $training
     * @return \Illuminate\Http\Response
     */
    public function index($companyId, Certificate $certificate)
    {
        $company = Company::findOrFail($companyId);

        $trainings = array();

        foreach ($company->departments as $department) {
            foreach ($department->trainings as $training) {
                $trainings[] = $training;
            }
        }

        return view('user.trainings.index', compact('trainings', 'company', 'certificate'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        //
    }


}
