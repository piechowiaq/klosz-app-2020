<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use function compact;
use function round;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function home(): RedirectResponse
    {
        $user = Auth::user();

        if ($user->companies()->count() === 1) {
            $company = $user->companies()->first();

            $companyId = $company->id;

            return Redirect::action('User\HomeController@index', $companyId);
        }

        return $user->isSuperAdmin() ? Redirect::action('Admin\AdminController@index') : view('user.home', compact('user'));
    }

    public function index(Company $company): Renderable
    {
        $companyTrainings = $company->trainings;

        $collection = collect([]);

        foreach ($companyTrainings as $training) {
            $collection->push($training->employees->where('company_id', $company)->count() === 0 ? 0 : round($training->employees()->certified($training, $company)->count() / $training->employees->where('company_id', $company)->count() * 100));
        }

        $average = round($collection->avg());

        $companyRegistries = $company->registries;

        $collection = collect();

        foreach ($company->registries as $registry) {
            foreach ($registry->reports->where('company_id', $company->id) as $report) {
                if ($report->expiry_date <= now()) {
                    continue;
                }

                $collection->push($report);
            }
        }

        $validRegistries = $collection->unique('registry_id')->count();

        $registryChartValue = $companyRegistries->count() === 0
            ? 0
            : round(
                $validRegistries / $companyRegistries->count() * 100,
            );

        return view(
            'user.dashboard',
            compact('company', 'companyTrainings', 'average', 'companyRegistries', 'registryChartValue'),
        );
    }
}
