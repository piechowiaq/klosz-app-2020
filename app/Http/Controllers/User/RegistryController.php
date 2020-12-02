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

    public function index(Company $company, Report $report): Renderable
    {
        $companyRegistries =  $company->registries;

        return view('user.registries.index')->with(['companyRegistries' => $companyRegistries, 'company' => $company, 'report' => $report]);
    }

    public function show(Company $company, Registry $registry, Report $report): Renderable
    {
        return view('user.registries.show')->with(['registry' => $registry, 'company' => $company, 'report' => $report]);
    }
}
