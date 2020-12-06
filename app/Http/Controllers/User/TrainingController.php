<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Training;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View as IlluminateView;

use function view;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function index(Company $company, Certificate $certificate)
    {
        $companyTrainings =  $company->trainings()->paginate(15);

        return view('user.trainings.index', ['companyTrainings' => $companyTrainings, 'company' => $company, 'certificate' => $certificate, 'companyId' => $company]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Company $company, Training $training)
    {
        $trainingEmployees = $training->getEmployees()->filter(static function (Employee $employee) use ($company) {
            return (string) $employee->getCompany()->pluck('id')->toArray()[0] === $company->getId();
        });

        return view('user.trainings.show', ['training' => $training, 'company' => $company, 'trainingEmployees' => $trainingEmployees]);
    }
}
