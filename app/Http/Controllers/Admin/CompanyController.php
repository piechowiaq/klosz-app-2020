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
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View as IlluminateView;

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

    /**
     * @return Factory|IlluminateView
     */
    public function index()
    {
        $this->authorize('update');

        $companies = Company::all();

        return view('admin.companies.index', ['companies' => $companies]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create()
    {
        $this->authorize('update');

        $company     = new Company();
        $departments = Department::all();
        $registries  = Registry::all();

        return view('admin.companies.create', ['company' => $company, 'departments' => $departments, 'registries' => $registries]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function store(StoreCompanyRequest $request)
    {
        $this->authorize('update');

        $company = new Company();
        $company->setName($request->get('name'));
        $company->save();

        $company->setDepartments($request->get('department_id'));
        $company->setRegistries($request->get('registry_id'));

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

            $company->setPositions($positions);
            $company->setTrainings($trainings);
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

    /**
     * @return Factory|IlluminateView
     */
    public function show(Company $company)
    {
        $this->authorize('update');

        return view('admin.companies.show', ['company' => $company]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Company $company)
    {
        $this->authorize('update');

        $departments = Department::all();

        $registries = Registry::all();

        return view('admin.companies.edit', ['company' => $company, 'departments' => $departments, 'registries' => $registries]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $this->authorize('update');

        $company->update($request->get('name'));

        $company->setDepartments($request->get('department_id'));
        $company->setRegistries($request->get('registry_id'));

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

            $company->setPositions($positions);
            $company->setTrainings($trainings);
        }

            return redirect($company->path());
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function destroy(Company $company)
    {
        $this->authorize('update');

        $company->delete();

        return redirect('admin/companies');
    }
}
