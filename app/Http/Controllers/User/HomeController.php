<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\User;
use DateTime;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View as IlluminateView;

use function assert;
use function collect;
use function round;
use function view;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @return RedirectResponse|Factory|IlluminateView
     */
    public function home()
    {
        $user = Auth::user();

        assert($user instanceof User);

        if ($user->getCompanies()->count() === 1) {
            $company = $user->getCompanies()->first();

            $companyId = $company->id;

            return Redirect::action('User\HomeController@index', $companyId);
        }

        if ($user->isSuperAdmin()) {
            return Redirect::action('Admin\AdminController@index');
        }

        return view('user.home', ['user' => $user]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function index(Company $company)
    {
        $collection = collect([]);

        foreach ($company->getTrainings() as $training) {
            $collection->push(
                $training->getEmployees()->where('company_id', $company->getId())->count() === 0
                    ? 0
                    : round(
                        Employee::getCertifiedByTrainingAndCompany($training, $company)->count()
                        / $training->getEmployees()->where('company_id', $company->getId())->count()
                        * 100
                    )
            );
        }

        $average = round($collection->avg());

        $collection = collect();

        foreach ($company->getRegistries() as $registry) {
            foreach ($registry->getReports()->where('company_id', $company->getId()) as $report) {

                if ($report->getExpiryDate() <= new DateTime('now')) {
                    continue;
                }

                $collection->push($report);
            }
        }

        $validRegistries = $collection->unique('registry_id')->count();

        $registryChartValue = $company->getRegistries()->count() === 0 ? 0 : round($validRegistries / $company->getRegistries()->count() * 100);

        return view('user.dashboard', ['company' => $company, 'companyTrainings' => $company->getTrainings(), 'average' => $average, 'companyRegistries' => $company->getRegistries(), 'registryChartValue' => $registryChartValue]);
    }
}
