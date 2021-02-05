<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Http\Controllers\Controller;
use App\Training;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as IlluminateView;

use function view;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Training::class, 'training', [
            'except' => ['show'],
        ]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function index(Company $company, Certificate $certificate)
    {
        $companyTrainings =  $company->getTrainings();

        return view('user.trainings.index', ['companyTrainings' => $companyTrainings, 'company' => $company, 'certificate' => $certificate]);
    }

    /**
     * @return Factory|IlluminateView
     *
     * @throws AuthorizationException
     */
    public function show(Company $company, Training $training)
    {

        $this->authorize('view', [$training, $company]);

        $trainingEmployees = $training->getEmployeesByCompany($company);

        return view('user.trainings.show', ['company' => $company, 'training' => $training, 'trainingEmployees' => $trainingEmployees]);
    }
}
