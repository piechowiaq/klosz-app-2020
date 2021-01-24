<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Core\Department\Domain\Repository\DepartmentRepositoryInterface;
use App\Core\Registry\Domain\Repository\RegistryRepositoryInterface;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Position;
use App\Registry;
use App\Training;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View as IlluminateView;

use function is_array;
use function redirect;
use function route;
use function view;

class CompanyController extends Controller
{
       /**
        * @return Factory|IlluminateView
        */
    public function index()
    {
        $companies = Company::getAll();

        return view('admin.companies.index', ['companies' => $companies]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create()
    {
        $departments = Department::getAll();
        $registries  = Registry::getAll();

        return view('admin.companies.create', ['departments' => $departments, 'registries' => $registries]);
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function store(RegistryRepositoryInterface $registryRepository, DepartmentRepositoryInterface $departmentRepository, StoreCompanyRequest $request)
    {
        $company = new Company();
        $company->setName($request->get('name'));
        $company->save();

        $registryIds = $request->get('registry_ids');

        if (is_array($registryIds)) {
            $registries = $registryRepository->getManyByIds($registryIds);
            $company->setRegistries($registries);
        }

        $departmentIds = $request->get('department_ids');
        if (is_array($departmentIds)) {
            $departments = $departmentRepository->getManyByIds($departmentIds);

            /**
             * @var Collection|Position[]
             */
            $positions = $departments->flatMap(static function (Department $department) {
                return $department->getPositions();
            });

            /**
             * @var Collection|Training[]
             */
            $trainings = $positions->flatMap(static function (Position $position) {
                return $position->getTrainings();
            });

            $company->setDepartments($departments);
            $company->setPositions($positions);
            $company->setTrainings($trainings);
        }

        return redirect(route('admin.companies.show', ['company' => $company]));
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Company $company)
    {
        return view('admin.companies.show', ['company' => $company]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Company $company)
    {
        $departments = Department::getAll();
        $registries  = Registry::getAll();

        return view('admin.companies.edit', ['company' => $company, 'departments' => $departments, 'registries' => $registries]);
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function update(RegistryRepositoryInterface $registryRepository, DepartmentRepositoryInterface $departmentRepository, UpdateCompanyRequest $request, Company $company)
    {
        $company->setName($request->get('name'));
        $company->save();

        $registryIds = $request->get('registry_ids');
        $registries  = new Collection();
        if (is_array($registryIds)) {
            $registries = $registryRepository->getManyByIds($registryIds);
        }

        $company->setRegistries($registries);

        $departmentIds = $request->get('department_ids');

        $departments = new Collection();
        $positions   = new Collection();
        $trainings   = new Collection();

        if (is_array($departmentIds)) {
            $departments = $departmentRepository->getManyByIds($departmentIds);

            /**
             * @var Collection|Position[]
             */
            $positions = $departments->flatMap(static function (Department $department) {
                return $department->getPositions();
            });

            /**
             * @var Collection|Training[]
             */
            $trainings = $positions->flatMap(static function (Position $position) {
                return $position->getTrainings();
            });
        }

        $company->setDepartments($departments);
        $company->setPositions($positions);
        $company->setTrainings($trainings);

        return redirect(route('admin.companies.show', ['company' => $company]));
    }

    /**
     * @return RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect(route('admin.companies.index'));
    }
}
