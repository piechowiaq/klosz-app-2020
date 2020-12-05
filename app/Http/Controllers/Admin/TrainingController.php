<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Position;
use App\Training;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View as IlluminateView;

use function redirect;
use function request;
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
     */
    public function store(StoreTrainingRequest $request)
    {
        $this->authorize('update');

        $training = new Training();
        $training->setName($request->get('name'));
        $training->setDescription($request->get('description'));
        $training->setValidFor($request->get('valid_for'));
        $training->save();

        $training->setPositions($request->get('position_id'));

        foreach ($training->positions as $position) {
            $training->departments()->sync($position->department_id, false);
            foreach ($position->employees as $employee) {
                $training->employees()->sync($employee, false);
            }
        }

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

        $training->update(request(['name', 'description', 'valid_for']));

        $training->save();

        $training->setPositions($request->get('position_id'));

        foreach ($training->positions as $position) {
            $training->departments()->sync($position->department_id, false);
            foreach ($position->employees as $employee) {
                $training->employees()->sync($employee, false);
            }
        }

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
