<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Department\Domain\Repository\DepartmentRepositoryInterface;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Position;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View as IlluminateView;

use function redirect;
use function route;
use function view;

class PositionController extends Controller
{
    /**
     * @return Factory|IlluminateView
     */
    public function index()
    {
        $positions = Position::getAll();

        return view('admin.positions.index', ['positions' => $positions]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create()
    {
        $departments = Department::getAll();

        return view('admin.positions.create', ['departments' => $departments]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function store(DepartmentRepositoryInterface $departmentRepository, StorePositionRequest $request)
    {
        $department = $departmentRepository->getById($request->get('department_id'));
        if ($department === null) {
            throw new Exception('No department found!');
        }

        $position = new Position();
        $position->setName($request->get('name'));
        $position->setDepartment($department);
        $position->save();

        $companies = $department->getCompanies()->filter(static function ($company) {
            return $company;
        });

        $position->setCompanies($companies);

        return redirect(route('admin.positions.show', ['position' => $position]));
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Position $position)
    {
        return view('admin.positions.show', ['position' => $position]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Position $position)
    {
        $departments = Department::getAll();

        return view('admin.positions.edit', ['position' => $position, 'departments' => $departments]);
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function update(DepartmentRepositoryInterface $departmentRepository, UpdatePositionRequest $request, Position $position)
    {
        $department = $departmentRepository->getById($request->get('department_id'));
        if ($department === null) {
            throw new Exception('No department found!');
        }

        $position->setName($request->get('name'));
        $position->setDepartment($department);
        $position->save();

        $companies = new Collection();

        foreach ($department->getCompanies() as $company) {
            $companies->add($company);
        }

        $position->setCompanies($companies);

        return redirect(route('admin.positions.show', ['position' => $position]));
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function destroy(Position $position)
    {
        $position->delete();

        return redirect(route('admin.positions.index'));
    }
}
