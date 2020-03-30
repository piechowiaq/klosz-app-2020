<?php

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Training;
use Carbon\Carbon;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $companyId
     * @param Certificate $certificate
     * @return \Illuminate\Http\Response
     */
    public function index($companyId, Certificate $certificate)
    {
        $company = Company::findOrFail($companyId);

        $trainings = collect();
        $certificates = collect();

        foreach ($company->positions as $position) {
            foreach ($position->trainings as $training) {
                $trainings[] = $training;
//               dd($training->employees = \App\Employee::with('trainings')->whereHas('certificates', function($q) use ($training) {
//                                    $q->where('expiry_date', '>', \Carbon\Carbon::now())
//                                      ->where('training_id', $training->id);
//                                      }
//                                      )->count());



            }
        }

       $trainings=$trainings->unique('id');

//        dd($trainings->employees);
//
//        foreach ($trainings as $training) {
//            foreach ($training->certificates as $certificate) {
//                $certificates[] = $certificate->where('training_id', $training->id)
//                    ->where('expiry_date', '>', Carbon::now())
//                    ->get();
//            }
//        }
//
//        dd($certificates);






//        foreach ($trainings as $training) {
//            foreach ($training->employees as $employee) {
//                foreach ($employee->certificates as $certificate) {
//
//                   dd( $certificate->where('training_id', $training->id)
//                        ->where('expiry_date', '>', Carbon::now())
//                        ->get());
//                }
//            }
//        }
//        dd($amount->where('training_id', 3));
//        $count = collect();
//        foreach ($trainings as $training){
////            foreach ($training->employees as $employee){
//                foreach ($employee->certificates as $certificate) {
//                    $count[] = $certificate;
//                }}
//
//            $number =  $count ->where('training_id', $training->id)
//                               ->where('created_at', $training->id)
//                              ->where('expiry_date', >', Carbon::now())
//                              ->where;
//
//
//
//        }



        return view('user.trainings.index', compact('trainings', 'company', 'certificate'));
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
