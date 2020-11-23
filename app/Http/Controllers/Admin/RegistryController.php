<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegistryRequest;
use App\Http\Requests\UpdateRegistryRequest;
use App\Registry;


class RegistryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('update');

        $registries = Registry::all();

        return view('admin.registries.index', compact('registries'));
    }

    public function create()
    {
        $this->authorize('update');

        $registry = new Registry();

        return view('admin.registries.create', compact( 'registry' ));
    }

    public function store(StoreRegistryRequest $request)
    {
        $this->authorize('update');

        $registry = new Registry(request(['name', 'description', 'valid_for']));

        $registry->save();

        return redirect($registry->path());
    }

    public function show(Registry $registry)
    {
        $this->authorize('update');

        return view('admin.registries.show', compact('registry'));
    }

    public function edit(Registry $registry)
    {
        $this->authorize('update');

        return view('admin.registries.edit', compact('registry'));
    }

    public function update(UpdateRegistryRequest $request, Registry $registry)
    {
        $this->authorize('update');

        $registry->update(request(['name', 'description', 'valid_for']));

        $registry->save();

        return redirect($registry->path());
    }

    public function destroy(Registry $registry)
    {
        $this->authorize('update');

        $registry->delete();

        return redirect('admin/registries');
    }
}
