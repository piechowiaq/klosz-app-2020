<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Http\Controllers\Controller;
use App\Registry;
use App\Report;
use Illuminate\Contracts\Support\Renderable;

use function view;

class RegistryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    public function index($companyId, Report $report): Renderable
    {
        $company = Company::findOrfail($companyId);

        $companyRegistries =  $company->registries;

        return view('user.registries.index')->with(['companyRegistries' => $companyRegistries, 'company' => $company, 'report' => $report]);
    }

    public function show($companyId, Registry $registry, Report $report): Renderable
    {
        $company = Company::findOrFail($companyId);

        return view('user.registries.show')->with(['registry' => $registry, 'company' => $company, 'report' => $report]);
    }
}
