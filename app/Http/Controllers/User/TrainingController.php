<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Http\Controllers\Controller;
use App\Training;
use Illuminate\Contracts\Support\Renderable;

use function compact;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    public function index(Company $company, Certificate $certificate): Renderable
    {
        $companyTrainings =  $company->trainings()->paginate(15);

        $companyId = $company->id;

        return view('user.trainings.index', compact('companyTrainings', 'company', 'certificate', 'companyId'));
    }

    public function show(Company $company, Training $training): Renderable
    {
        $trainingEmployees = $training->employees->filter(static function ($employee) use ($company) {
            return $employee->company_id === $company;
        });

        return view('user.trainings.show', compact('training', 'company', 'trainingEmployees'));
    }
}
