<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Http\Controllers\Controller;
use App\Registry;
use App\Report;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View as IlluminateView;

use function view;

class RegistryController extends Controller
{
    /**
     * @return Factory|IlluminateView
     */
    public function index(Company $company, Report $report)
    {
        return view('user.registries.index', ['companyRegistries' => $company->getRegistries(), 'company' => $company, 'report' => $report]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Company $company, Registry $registry, Report $report)
    {
        return view('user.registries.show', ['registry' => $registry, 'company' => $company, 'report' => $report]);
    }
}
