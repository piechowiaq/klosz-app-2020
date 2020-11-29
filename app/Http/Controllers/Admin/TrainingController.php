<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Position;
use App\Training;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use function compact;
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
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $this->authorize('update');

        $trainings = Training::all();

        return view('admin.trainings.index', compact('trainings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('update');

        $training = new Training();

        $positions = Position::all();

        return view('admin.trainings.create', compact('training', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(StoreTrainingRequest $request): Response
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

    /**
     * Display the specified resource.
     */
    public function show(Training $training): Response
    {
        $this->authorize('update');

        return view('admin.trainings.show', compact('training'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Training $training): Response
    {
        $this->authorize('update');

        $positions = Position::all();

        return view('admin.trainings.edit', compact('training', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     */
    public function update(UpdateTrainingRequest $request, Training $training): Response
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Training $training): Response
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
