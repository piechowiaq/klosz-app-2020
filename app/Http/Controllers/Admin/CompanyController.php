<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Position;
use App\Registry;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

use function compact;
use function redirect;
use function request;
use function view;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->authorizeResource(Company::class, 'company');
    }

    public function index(): Renderable
    {
        $companies = Company::all();

        return view('admin.companies.index')->with(['companies' => $companies]);
    }

    public function create(): Renderable
    {
        $company     = new Company();
        $departments = Department::all();
        $registries  = Registry::all();

        return view('admin.companies.create')->with(['company' => $company, 'departments' => $departments, 'registries' => $registries]);
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $company = new Company();
        $company->setName($request->get('name'));
        $company->save();

        $company->departments()->sync($request->get('department_id'));
        $company->registries()->sync($request->get('registry_id'));

        if (! empty(request('department_id'))) {
            $positions = Position::whereIn('department_id', request('department_id'))->get();

            $company->positions()->sync($positions);
            $trainings = [];
            foreach ($positions as $position) {
                foreach ($position->trainings as $training) {
                    $company->trainings()->sync($training, false);
                }
            }
        } else {
            $positions = [];
            $trainings = [];

            $company->positions()->sync($positions);
            $company->trainings()->sync($trainings);
        }

//        $departmentsId =  $position->trainings->map(function($training){
//           $company->trainings()->sync($position->trainings);
//        });
//
//        Position::whereIn('department_id', $departmentsId)
//                            ->get()
//                            ->map(function($position) use ($company)
//        {
//           $position->companies()->sync($company,false);
//        });

            return redirect($company->path());
    }

    public function show(Company $company)
    {
        return view('admin.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        $departments = Department::all();

        $registries = Registry::all();

        return view('admin.companies.edit', compact('company', 'departments', 'registries'));
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update(request(['name']));

        $company->departments()->sync(request('department_id'));

        $company->registries()->sync(request('registry_id'));

        if (! empty(request('department_id'))) {
            $positions = Position::whereIn('department_id', request('department_id'))->get();

            $company->positions()->sync($positions);
            $trainings = [];
            foreach ($positions as $position) {
                foreach ($position->trainings as $training) {
                    $company->trainings()->sync($training, false);
                }
            }
        } else {
            $positions = [];
            $trainings = [];

            $company->positions()->sync($positions);
            $company->trainings()->sync($trainings);
        }

            return redirect($company->path());
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect('admin/companies');
    }
}
