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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('update');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('update');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreRegistryRequest $request)
    {
        $this->authorize('update');

        $registry = new Registry(request(['name', 'description', 'valid_for']));

        $registry->save();

        return redirect($registry->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Registry  $registry
     * @return \Illuminate\Http\Response
     */
    public function show(Registry $registry)
    {
        $this->authorize('update');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Registry  $registry
     * @return \Illuminate\Http\Response
     */
    public function edit(Registry $registry)
    {
        $this->authorize('update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Registry  $registry
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegistryRequest $request, Registry $registry)
    {
        $this->authorize('update');

        $registry->update(request(['name', 'description', 'valid_for']));

        $registry->save();

        return redirect($registry->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Registry  $registry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registry $registry)
    {
        $this->authorize('update');

        $registry->delete();

        return redirect('admin/registries');
    }
}
