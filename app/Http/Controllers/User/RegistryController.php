<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Http\Controllers\Controller;
use App\Registry;
use App\Report;
use Illuminate\Contracts\Support\Renderable;

use function compact;

class RegistryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    public function index(Company $company, Report $report): Renderable
    {
        $companyId = $company->getId();

        $companyRegistries = $company->registries;

        return view('user.registries.index', compact('companyRegistries', 'company', 'report'));
    }

    public function show(Company $company, Registry $registry, Report $report): Renderable
    {
        return view('user.registries.show', compact('registry', 'company', 'report'));
    }
}
