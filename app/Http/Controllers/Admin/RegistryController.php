<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegistryRequest;
use App\Http\Requests\UpdateRegistryRequest;
use App\Registry;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View as IlluminateView;

use function redirect;
use function route;
use function view;

class RegistryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Factory|IlluminateView
     *
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('update');

        $registries = Registry::getAll();

        return view('admin.registries.index', ['registries' => $registries]);
    }

    /**
     * @return Factory|IlluminateView
     *
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('update');

        return view('admin.registries.create');
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws AuthorizationException
     */
    public function store(StoreRegistryRequest $request)
    {
        $this->authorize('update');

        $registry = new Registry();
        $registry->setName($request->get('name'));
        $registry->setDescription($request->get('description'));
        $registry->setValidFor((int) $request->get('valid_for'));
        $registry->save();

        return redirect(route('admin.registries.show', ['registry' => $registry]));
    }

    /**
     * @return Factory|IlluminateView
     *
     * @throws AuthorizationException
     */
    public function show(Registry $registry)
    {
        $this->authorize('update');

        return view('admin.registries.show', ['registry' => $registry]);
    }

    /**
     * @return Factory|IlluminateView
     *
     * @throws AuthorizationException
     */
    public function edit(Registry $registry)
    {
        $this->authorize('update');

        return view('admin.registries.edit', ['registry' => $registry]);
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws AuthorizationException
     */
    public function update(UpdateRegistryRequest $request, Registry $registry)
    {
        $this->authorize('update');

        $registry->setName($request->get('name'));
        $registry->setDescription($request->get('description'));
        $registry->setValidFor((int) $request->get('valid_for'));
        $registry->save();

        return redirect(route('admin.registries.show', ['registry' => $registry]));
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy(Registry $registry)
    {
        $this->authorize('update');

        $registry->delete();

        return redirect(route('admin.registries.index'));
    }
}
