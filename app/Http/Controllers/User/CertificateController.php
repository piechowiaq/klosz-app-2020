<?php

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCertificateRequest;
use App\Http\Requests\UpdateUserCertificateRequest;
use App\Training;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $companyId
     * @param Certificate $certificate
     * @return \Illuminate\Http\Response
     */
    public function create($companyId, Certificate $certificate)
    {
        $this->authorize('update', $certificate);

        $certificate = new Certificate();

        $company = Company::findOrFail($companyId);

        $collection = collect();

        foreach ($company->positions as $position) {

                foreach ($position->trainings as $training){
                    $collection[] = $training;}
        }

        $trainings = $collection->unique('name');

        $employees = collect();

        foreach ($company->employees as $employee) {

                  $employees[] = $employee;
        }

        return view('user.certificates.create', compact( 'trainings', 'certificate', 'company', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserCertificateRequest $request
     * @param $companyId
     * @param Certificate $certificate
     * @return void
     */
    public function store(StoreUserCertificateRequest $request, $companyId, Certificate $certificate )
    {
        $this->authorize('update', $certificate);

        $expiry_date = Carbon::create(request('training_date'))->addMonths( Training::where('id', request('training_id'))->first()->valid_for)->toDateString();

        $certificate = new Certificate(request(['training_id', 'company_id', 'training_date']));

        $certificate->company_id = $companyId;

        $certificate->expiry_date = $expiry_date;

        $certificate->save();

        $certificate->employees()->sync(request('employee_id'));

        return redirect($certificate->userpath($companyId));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show($companyId, Certificate $certificate)
    {
        $company = Company::findOrFail($companyId);



        return view('user.certificates.show', compact('certificate', 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Certificate $certificate
     * @param $companyId
     * @return void
     */
    public function edit( $companyId, Certificate $certificate)
    {
        $this->authorize('update', $certificate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserCertificateRequest $request
     * @param $companyId
     * @param \App\Certificate $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserCertificateRequest $request, $companyId, Certificate $certificate)
    {
        $this->authorize('update', $certificate);

        $expiry_date = Carbon::create(request('training_date'))->addMonths( Training::where('id', request('training_id'))->first()->valid_for)->toDateString();

        $certificate->update(request(['training_id', 'company_id', 'training_date']));

        $certificate->company_id = $companyId;

        $certificate->expiry_date = $expiry_date;

        $certificate->save();

        return redirect($certificate->userpath($companyId));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {
        //
    }
}
