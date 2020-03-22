<?php

namespace App\Http\Controllers\Admin;

use App\Certificate;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCertificateRequest;
use App\Http\Requests\UpdateCertificateRequest;
use Illuminate\Http\Request;


class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('update');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
    public function store(StoreCertificateRequest $request)
    {
        $this->authorize('update');

        $certificate = new Certificate(request(['training_id']));


        $certificate->save();

        return redirect($certificate->path());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Certificate $certificate
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Certificate $certificate)
    {
        $this->authorize('update');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Certificate $certificate
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit(Certificate $certificate)
    {
        $this->authorize('update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Certificate $certificate
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function update(UpdateCertificateRequest $request, Certificate $certificate)
    {
        $this->authorize('update');

        $certificate->update(request(['training_id']));

        $certificate->save();

        return redirect($certificate->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Certificate $certificate
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function destroy(Certificate $certificate)
    {
        $this->authorize('update');

        $certificate->delete();

        return redirect('admin/certificates');
    }
}
