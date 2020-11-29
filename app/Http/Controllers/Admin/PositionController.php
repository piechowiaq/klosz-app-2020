<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Position;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

use function redirect;
use function view;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Renderable
    {
//        $this->authorize('update');

        $positions = Position::all();

        return view('admin.positions.index')->with(['positions' => $positions]);
    }

    public function create(): Renderable
    {
        $this->authorize('update');

        $position = new Position();

        $departments = Department::all();

        return view('admin.positions.create')->with(['position' => $position, 'departments' => $departments]);
    }

    public function store(StorePositionRequest $request): RedirectResponse
    {
        $this->authorize('update');

        $position = Position::create($request->validated());

        return redirect($position->path());
    }

    public function show(Position $position): Renderable
    {
        $this->authorize('update');

        return view('admin.positions.show')->with(['position' => $position]);
    }

    public function edit(Position $position): Renderable
    {
        $this->authorize('update');

        $departments = Department::all();

        return view('admin.positions.edit')->with(['position' => $position, 'departments' => $departments]);
    }

    public function update(UpdatePositionRequest $request, Position $position): RedirectResponse
    {
        $this->authorize('update');

        $position->update($request->validated());

        return redirect($position->path());
    }

    public function destroy(Position $position): RedirectResponse
    {
        $this->authorize('update');

        $position->delete();

        return redirect('admin/positions');
    }
}
