<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Position;

use function compact;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $this->authorize('update');

        $positions = Position::all();

        return view('admin.positions.index', compact('positions'));
    }

    public function create()
    {
        $this->authorize('update');

        $position = new Position();

        $departments = Department::all();

        return view('admin.positions.create', compact('position', 'departments'));
    }

    public function store(StorePositionRequest $request)
    {
        $this->authorize('update');

        $position = Position::create($request->validated());

        return redirect($position->path());
    }

    public function show(Position $position)
    {
        $this->authorize('update');

        return view('admin.positions.show', compact('position'));
    }

    public function edit(Position $position)
    {
        $this->authorize('update');

        $departments = Department::all();

        return view('admin.positions.edit', compact('position', 'departments'));
    }

    public function update(UpdatePositionRequest $request, Position $position)
    {
        $this->authorize('update');

        $position->update($request->validated());

        return redirect($position->path());
    }

    public function destroy(Position $position)
    {
        $this->authorize('update');

        $position->delete();

        return redirect('admin/positions');
    }
}
