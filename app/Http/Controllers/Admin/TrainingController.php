<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Position;
use App\Training;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View as IlluminateView;

use function assert;
use function redirect;
use function view;

class TrainingController extends Controller
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

        $trainings = Training::all();

        return view('admin.trainings.index', ['trainings' => $trainings]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create()
    {
        $this->authorize('update');

        $training = new Training();

        $positions = Position::all();

        return view('admin.trainings.create', ['training' => $training, 'positions' => $positions]);
    }

    /**
     * @return  RedirectResponse|Redirector
     * @throws Exception
     */
    public function store(StoreTrainingRequest $request)
    {
        $this->authorize('update');

        $training = new Training();
        $training->setName($request->get('name'));
        $training->setDescription($request->get('description'));
        $training->setValidFor((int) $request->get('valid_for'));
        $training->save();

        $training->setPositions($request->get('position_id'));

        $departments = new Collection();
        $employees   = new Collection();

        foreach ($training->getPositions() as $position) {
            $departments->add($position->getDepartment());
            $employees->add($position->getEmployees());
        }

        $training->setDepartments($departments);
        $training->setEmployees($employees);

        /**
         * @var Collection|Company[]
         */
        $companies = $training->getDepartments()->flatMap(static function (Department $department) {
            return $department->getCompanies();
        });

        $training->setCompanies($companies);

        return redirect($training->path());
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Training $training)
    {
        $this->authorize('update');

        return view('admin.trainings.show', ['training' => $training]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Training $training)
    {
        $this->authorize('update');

        $positions = Position::all();

        return view('admin.trainings.edit', ['training' => $training, 'positions' => $positions]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function update(UpdateTrainingRequest $request, Training $training)
    {
        $this->authorize('update');

        $training->setName($request->get('name'));
        $training->setDescription($request->get('description'));
        $training->setValidFor((int) $request->get('valid_for'));
        $training->save();

        $training->setPositions($request->get('position_id'));

        $departments = new Collection();
        $employees   = new Collection();

        foreach ($training->getPositions() as $position) {
            $departments->add($position->getDepartment());
            $employees->add($position->getEmployees());
        }

        $training->setDepartments($departments);
        $training->setEmployees($employees);

        return redirect($training->path());
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function destroy(Training $training)
    {
        $this->authorize('update');

        $training->delete();

        return redirect('admin/trainings');
    }
}
