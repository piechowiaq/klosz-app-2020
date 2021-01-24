<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Http\Controllers\Controller;
use App\User;
use DateTime;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as IlluminateView;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

use function assert;
use function round;
use function view;

class HomeController extends Controller
{
    /**
     * @return RedirectResponse|Factory|IlluminateView
     */
    public function home()
    {
        $user = Auth::user();

        assert($user instanceof User);

        if ($user->getCompanies()->count() === 1) {
            $company = $user->getCompanies()->first();

            return view('user.dashboard', ['company' => $company]);
        }

        if ($user->isSuperAdmin()) {
            return view('admin.home');
        }

        return view('user.home', ['user' => $user]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function index(Company $company)
    {
        $companyValidTrainings = new Collection();

        foreach ($company->getTrainings() as $training) {
            $companyValidTrainings->push(
                $training->getEmployees()->where('company_id', $company->getId())->count() === 0
                    ? 0
                    : round(
                        $training->getCertifiedEmployeesByCompany($company, $training)->count()
                        / $training->getEmployees()->where('company_id', $company->getId())->count()
                        * 100
                    )
            );
        }

        $trainingChartValue = round($companyValidTrainings->avg());

        $companyValidReports = new Collection();

        foreach ($company->getReports() as $report) {
            if ($report->getExpiryDate() <= new DateTime('now')) {
                continue;
            }

            $companyValidReports->push($report);
        }

        $validRegistries = $companyValidReports->unique('registry_id')->count();

        $registryChartValue = $company->getRegistries()->count() === 0 ? 0 : round($validRegistries / $company->getRegistries()->count() * 100);

        return view('user.dashboard', ['company' => $company, 'companyTrainings' => $company->getTrainings(), 'trainingChartValue' => $trainingChartValue, 'companyRegistries' => $company->getRegistries(), 'registryChartValue' => $registryChartValue]);
    }
}
