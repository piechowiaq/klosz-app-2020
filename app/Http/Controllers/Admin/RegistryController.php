<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegistryRequest;
use App\Http\Requests\UpdateRegistryRequest;
use App\Registry;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

use function redirect;
use function request;
use function view;

class RegistryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Renderable
    {
        $this->authorize('update');

        $registries = Registry::all();

        return view('admin.registries.index')->with(['registries' => $registries]);
    }

    public function create(): Renderable
    {
        $this->authorize('update');

        $registry = new Registry();

        return view('admin.registries.create')->with(['registry' => $registry]);
    }

    public function store(StoreRegistryRequest $request): RedirectResponse
    {
        $this->authorize('update');

        $registry = new Registry(request(['name', 'description', 'valid_for']));

        $registry->save();

        return redirect($registry->path());
    }

    public function show(Registry $registry): Renderable
    {
        $this->authorize('update');

        return view('admin.registries.show')->with(['registry' => $registry]);
    }

    public function edit(Registry $registry): Renderable
    {
        $this->authorize('update');

        return view('admin.registries.edit')->with(['registry' => $registry]);
    }

    public function update(UpdateRegistryRequest $request, Registry $registry): RedirectResponse
    {
        $this->authorize('update');

        $registry->update(request(['name', 'description', 'valid_for']));

        $registry->save();

        return redirect($registry->path());
    }

    public function destroy(Registry $registry): RedirectResponse
    {
        $this->authorize('update');

        $registry->delete();

        return redirect('admin/registries');
    }
}
