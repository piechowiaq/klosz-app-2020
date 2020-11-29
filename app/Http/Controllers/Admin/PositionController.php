<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use function compact;
use function redirect;
use function view;

class PositionController extends Controller
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
//        $this->authorize('update');

        $positions = Position::all();

        return view('admin.positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('update');

        $position = new Position();

        $departments = Department::all();

        return view('admin.positions.create', compact('position', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(StorePositionRequest $request): Response
    {
        $this->authorize('update');

        $position = Position::create($request->validated());

        return redirect($position->path());
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position): Response
    {
        $this->authorize('update');

        return view('admin.positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position): Response
    {
        $this->authorize('update');

        $departments = Department::all();

        return view('admin.positions.edit', compact('position', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     */
    public function update(UpdatePositionRequest $request, Position $position): Response
    {
        $this->authorize('update');

        $position->update($request->validated());

        return redirect($position->path());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position): Response
    {
        $this->authorize('update');

        $position->delete();

        return redirect('admin/positions');
    }
}
