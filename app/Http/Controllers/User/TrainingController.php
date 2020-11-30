<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Http\Controllers\Controller;
use App\Training;
use Illuminate\Contracts\Support\Renderable;

use function view;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    public function index($companyId, Certificate $certificate): Renderable
    {
        $company = Company::findOrfail($companyId);

        $companyTrainings =  $company->trainings()->paginate(15);

        return view('user.trainings.index')->with(['companyTrainings' => $companyTrainings, 'company' => $company, 'certificate' => $certificate, 'companyId' => $companyId]);
    }

    public function show($companyId, Training $training): Renderable
    {
        $company = Company::findOrFail($companyId);

        $trainingEmployees = $training->employees->filter(static function ($employee) use ($companyId) {
            return $employee->company_id === $companyId;
        });

        return view('user.trainings.show')->with(['training' => $training, 'company' => $company, 'trainingEmployees' => $trainingEmployees]);
    }
}
