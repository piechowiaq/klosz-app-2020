<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegistryRequest;
use App\Http\Requests\UpdateRegistryRequest;
use App\Registry;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View as IlluminateView;

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
     * @return Factory|IlluminateView
     */
    public function index()
    {
        $this->authorize('update');

        $registries = Registry::all();

        return view('admin.registries.index', ['registries' => $registries]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create()
    {
        $this->authorize('update');

        $registry = new Registry();

        return view('admin.registries.create', ['registry' => $registry]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function store(StoreRegistryRequest $request)
    {
        $this->authorize('update');

        $registry = new Registry();
        $registry->setName($request->get('name'));
        $registry->setDescription($request->get('description'));
        $registry->setValidFor($request->get('vallid_for'));
        $registry->save();

        return redirect($registry->path());
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Registry $registry)
    {
        $this->authorize('update');

        return view('admin.registries.show', ['registry' => $registry]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Registry $registry)
    {
        $this->authorize('update');

        return view('admin.registries.edit', ['registry' => $registry]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function update(UpdateRegistryRequest $request, Registry $registry)
    {
        $this->authorize('update');

        $registry->update(request(['name', 'description', 'valid_for']));

        $registry->save();

        return redirect($registry->path());
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function destroy(Registry $registry)
    {
        $this->authorize('update');

        $registry->delete();

        return redirect('admin/registries');
    }
}
