<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Http\Controllers\Controller;
use App\Training;
use Illuminate\Http\Response;

use function compact;
use function view;

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
     */
    public function index($companyId, Certificate $certificate): Response
    {
        $company = Company::findOrfail($companyId);

        $companyTrainings =  $company->trainings()->paginate(15);

        return view('user.trainings.index', compact('companyTrainings', 'company', 'certificate', 'companyId'));
    }

    /**
     * Display the specified resource.
     */
    public function show($companyId, Training $training): Response
    {
        $company = Company::findOrFail($companyId);

        $trainingEmployees = $training->employees->filter(static function ($employee) use ($companyId) {
            return $employee->company_id === $companyId;
        });

        return view('user.trainings.show', compact('training', 'company', 'trainingEmployees'));
    }
}
