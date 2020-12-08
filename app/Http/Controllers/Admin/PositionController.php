<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

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
use function view;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Factory|IlluminateView
     */
    public function index()
    {
        $this->authorize('update');

        $positions = Position::all();

        return view('admin.positions.index', ['positions' => $positions]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create()
    {
        $this->authorize('update');

        $position = new Position();

        $departments = Department::all();

        return view('admin.positions.create', ['position' => $position, 'departments' => $departments]);
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function store(StorePositionRequest $request)
    {
        $this->authorize('update');

        $department = Department::getDepartmentById($request->get('department_id'));
        if ($department === null) {
            throw new Exception('No department found!');
        }

        $position = new Position();
        $position->setName($request->get('name'));
        $position->setDepartment($department);
        $position->save();

        $companies = new Collection();

        foreach ($department->getCompanies() as $company) {
            $companies->add($company);
        }

        $position->setCompanies($companies);

        return redirect($position->path());
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Position $position)
    {
        $this->authorize('update');

        return view('admin.positions.show', ['position' => $position]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Position $position)
    {
        $this->authorize('update');

        $departments = Department::all();

        return view('admin.positions.edit', ['position' => $position, 'departments' => $departments]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function update(UpdatePositionRequest $request, Position $position)
    {
        $this->authorize('update');

        $department = Department::getDepartmentById($request->get('department_id'));
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

        return redirect($position->path());
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function destroy(Position $position)
    {
        $this->authorize('update');

        $position->delete();

        return redirect('admin/positions');
    }
}
