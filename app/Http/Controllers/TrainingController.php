<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Position;
use App\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('update');

        $trainings = Training::all();

        return view('admin.trainings.index', compact('trainings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('update');

        $training = new Training();

        $positions = Position::all();
//
        return view('admin.trainings.create', compact( 'training', 'positions' ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingRequest $request)
    {
        $this->authorize('update');

        $training = new Training(request(['name', 'description', 'valid_for']));

        $training->save();

        $training->positions()->sync(request('position_id'));

        return redirect($training->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        $this->authorize('update');

        return view('admin.trainings.show', compact('training'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training)
    {
        $this->authorize('update');

        $positions = Position::all();

        return view('admin.trainings.edit', compact('training', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingRequest $request, Training $training)
    {
        $this->authorize('update');

        $training->update(request(['name', 'description', 'valid_for']));

        $training->save();

        $training->positions()->sync(request('position_id'));

        return redirect($training->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        $this->authorize('update');

        $training->delete();

        return redirect('admin/trainings');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'name'=> 'sometimes|required',
            'description' => 'required|min:3',
            'valid_for'=> 'required',

        ]);
    }
}
