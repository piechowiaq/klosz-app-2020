<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Position;
use App\Training;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

use function redirect;
use function request;
use function view;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Renderable
    {
        $this->authorize('update');

        $trainings = Training::all();

        return view('admin.trainings.index')->with(['trainings' => $trainings]);
    }

    public function create(): Renderable
    {
        $this->authorize('update');

        $training = new Training();

        $positions = Position::all();

        return view('admin.trainings.create')->with(['training' => $training, 'positions' => $positions]);
    }

    public function store(StoreTrainingRequest $request): RedirectResponse
    {
        $this->authorize('update');

        $training = new Training(request(['name', 'description', 'valid_for']));

        $training->save();

        $training->positions()->sync(request('position_id'));

        foreach ($training->positions as $position) {
            $training->departments()->sync($position->department_id, false);
            foreach ($position->employees as $employee) {
                $training->employees()->sync($employee, false);
            }
        }

        return redirect($training->path());
    }

    public function show(Training $training): Renderable
    {
        $this->authorize('update');

        return view('admin.trainings.show')->with(['training' => $training]);
    }

    public function edit(Training $training): Renderable
    {
        $this->authorize('update');

        $positions = Position::all();

        return view('admin.trainings.edit')->with(['training' => $training, 'positions' => $positions]);
    }

    public function update(UpdateTrainingRequest $request, Training $training): RedirectResponse
    {
        $this->authorize('update');

        $training->update(request(['name', 'description', 'valid_for']));

        $training->save();

        $training->positions()->sync(request('position_id'));

        foreach ($training->positions as $position) {
            $training->departments()->sync($position->department_id, false);
            foreach ($position->employees as $employee) {
                $training->employees()->sync($employee, false);
            }
        }

        return redirect($training->path());
    }

    public function destroy(Training $training): RedirectResponse
    {
        $this->authorize('update');

        $training->delete();

        return redirect('admin/trainings');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'name' => 'sometimes|required',
            'description' => 'required|min:3',
            'valid_for' => 'required',

        ]);
    }
}
