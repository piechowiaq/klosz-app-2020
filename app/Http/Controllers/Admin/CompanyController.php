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

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Renderable
    {
        $this->authorize('update');

        $companies = Company::all();

        return view('admin.companies.index', compact('companies'));
    }

    public function create(): Renderable
    {
        $this->authorize('update');

        $company = new Company();

        $departments = Department::all();

        $registries = Registry::all();

        return view('admin.companies.create', compact('company', 'departments', 'registries'));
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $this->authorize('update');

        $company = new Company(request(['name']));

        $company->save();

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

    public function show(Company $company): Renderable
    {
        $this->authorize('update');

        return view('admin.companies.show', compact('company'));
    }

    public function edit(Company $company): Renderable
    {
        $this->authorize('update');

        $departments = Department::all();

        $registries = Registry::all();

        return view('admin.companies.edit', compact('company', 'departments', 'registries'));
    }

    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $this->authorize('update');

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

    public function destroy(Company $company): RedirectResponse
    {
        $this->authorize('update');

        $company->delete();

        return redirect('admin/companies');
    }
}
