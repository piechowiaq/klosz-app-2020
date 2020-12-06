<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use Illuminate\View\View as IlluminateView;
use function collect;
use function now;
use function round;
use function view;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @return RedirectResponse|Renderable
     */
    public function home()
    {
        $user = Auth::user();

        if ($user->companies()->count() === 1) {
            $company = $user->companies()->first();

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
            $collection->push($training->employees->where('company_id', $company->getId())->count() === 0 ? 0 : round($training->employees()->certified($training, $company)->count() / $training->employees->where('company_id', $company->getId())->count() * 100));
        }

        $average = round($collection->avg());

        $collection = collect();

        foreach ($company->getRegistries() as $registry) {
            foreach ($registry->reports->where('company_id', $company->getId()) as $report) {
                if ($report->expiry_date <= now()) {
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
