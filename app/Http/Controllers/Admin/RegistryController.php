<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegistryRequest;
use App\Http\Requests\UpdateRegistryRequest;
use App\Registry;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use function compact;
use function redirect;
use function request;
use function view;

class RegistryController extends Controller
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

        $registries = Registry::all();

        return view('admin.registries.index', compact('registries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('update');

        $registry = new Registry();

        return view('admin.registries.create', compact('registry'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @throws AuthorizationException
     */
    public function store(StoreRegistryRequest $request): Response
    {
        $this->authorize('update');

        $registry = new Registry(request(['name', 'description', 'valid_for']));

        $registry->save();

        return redirect($registry->path());
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(Registry $registry): Response
    {
        $this->authorize('update');

        return view('admin.registries.show', compact('registry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registry $registry): Response
    {
        $this->authorize('update');

        return view('admin.registries.edit', compact('registry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     */
    public function update(UpdateRegistryRequest $request, Registry $registry): Response
    {
        $this->authorize('update');

        $registry->update(request(['name', 'description', 'valid_for']));

        $registry->save();

        return redirect($registry->path());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registry $registry): Response
    {
        $this->authorize('update');

        $registry->delete();

        return redirect('admin/registries');
    }
}
