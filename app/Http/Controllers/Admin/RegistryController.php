<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegistryRequest;
use App\Http\Requests\UpdateRegistryRequest;
use App\Registry;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View as IlluminateView;

use function redirect;
use function route;
use function view;

class RegistryController extends Controller
{
    /**
     * @return Factory|IlluminateView
     */
    public function index()
    {
        $registries = Registry::getAll();

        return view('admin.registries.index', ['registries' => $registries]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create()
    {
        return view('admin.registries.create');
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function store(StoreRegistryRequest $request)
    {
        $registry = new Registry();
        $registry->setName($request->get('name'));
        $registry->setDescription($request->get('description'));
        $registry->setValidFor((int) $request->get('valid_for'));
        $registry->save();

        return redirect(route('admin.registries.show', ['registry' => $registry]));
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Registry $registry)
    {
        return view('admin.registries.show', ['registry' => $registry]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Registry $registry)
    {
        return view('admin.registries.edit', ['registry' => $registry]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function update(UpdateRegistryRequest $request, Registry $registry)
    {
        $registry->setName($request->get('name'));
        $registry->setDescription($request->get('description'));
        $registry->setValidFor((int) $request->get('valid_for'));
        $registry->save();

        return redirect(route('admin.registries.show', ['registry' => $registry]));
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function destroy(Registry $registry)
    {
        $registry->delete();

        return redirect(route('admin.registries.index'));
    }
}
