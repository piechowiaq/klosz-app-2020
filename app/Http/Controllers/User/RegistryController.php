<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Http\Controllers\Controller;
use App\Registry;
use App\Report;
use Illuminate\Http\Response;

use function compact;

class RegistryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    public function index(Company $company, Report $report): Response
    {
        $companyId = $company->getId();

        $companyRegistries = $company->registries;

        return view('user.registries.index', compact('companyRegistries', 'company', 'report'));
    }

    public function show($companyId, Registry $registry, Report $report): Response
    {
        $company = Company::findOrFail($companyId);

        return view('user.registries.show', compact('registry', 'company', 'report'));
    }
}
