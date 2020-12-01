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

    public function index(Company $company, Certificate $certificate): Renderable
    {
        $companyTrainings =  $company->trainings()->paginate(15);

        return view('user.trainings.index')->with(['companyTrainings' => $companyTrainings, 'company' => $company, 'certificate' => $certificate, 'companyId' => $company]);
    }

    public function show(Company $company, Training $training): Renderable
    {
        $trainingEmployees = $training->employees->filter(static function ($employee) use ($company) {
            return $employee->company_id === $company;
        });

        return view('user.trainings.show')->with(['training' => $training, 'company' => $company, 'trainingEmployees' => $trainingEmployees]);
    }
}
