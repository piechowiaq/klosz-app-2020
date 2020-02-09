<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
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
//        $this->authorize('update');

        $positions = Position::all();

        return view('admin.positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('update');

        $position = new Position();

        $departments = Department::all();
//
        return view('admin.positions.create', compact( 'position', 'departments' ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePositionRequest $request)
    {
        //$this->authorize('update');

        $position = Position::create($request->validated());

        return redirect($position->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        return view('admin.positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        $departments = Department::all();

        return view('admin.positions.edit', compact('position', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePositionRequest $request, Position $position)
    {
        //$this->authorize('update');

        $position->update($request->validated());

        return redirect($position->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
//        $this->authorize('update');

        $position->delete();

        return redirect('admin/positions');
    }

}
