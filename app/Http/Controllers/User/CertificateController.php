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
    public function index($companyId, $trainingId)
    {
        $company =  Company::findOrfail($companyId);
        $training = Training::findOrfail($trainingId);

        return view('user.certificates.index', compact('training', 'company'));
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

        $companyTrainings =  $company->trainings;

        $companyEmployees =  $company->employees;



        return view('user.certificates.create', compact( 'companyTrainings', 'certificate', 'company', 'companyEmployees'));
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

        $certificate = new Certificate(request(['training_id', 'training_date']));

        $certificate->company_id = $companyId;

        $certificate->expiry_date = $expiry_date;

        $certificate->certificate_path = request('certificate_path')->storeAs('certificates', $certificate->training_date . ' ' . $certificate->training->name . ' ' . Carbon::now()->format('His') . '.' . request('certificate_path')->getClientOriginalExtension(), 'public');

        $certificate->save();

        $certificate->employees()->sync(request('employee_id'));

        $trainingId = $certificate->training_id;

        return redirect($certificate->userpath($companyId, $trainingId));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show($companyId, $trainingId, Certificate $certificate)
    {
        $company = Company::findOrFail($companyId);

        $training = Training::where($trainingId, $certificate->training_id);



        return view('user.certificates.show', compact('certificate', 'company','training'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Certificate $certificate
     * @param $companyId
     * @return void
     */
    public function edit($companyId, $trainingId, Certificate $certificate)
    {
        $this->authorize('update', $certificate);

        $company =  Company::findOrfail($companyId);

        $training = Training::findOrfail($trainingId);

        $companyTrainings =  $company->trainings;

        $companyEmployees =  $company->employees;

        return view ( 'user.certificates.edit', compact('company', 'companyTrainings', 'companyEmployees','training', 'certificate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserCertificateRequest $request
     * @param $companyId
     * @param \App\Certificate $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserCertificateRequest $request, $companyId, $trainingId, Certificate $certificate)
    {
        $this->authorize('update', $certificate);

        $expiry_date = Carbon::create(request('training_date'))->addMonths( Training::where('id',  $trainingId)->first()->valid_for)->toDateString();

        $certificate->update(request(['training_id', 'company_id', 'training_date']));

        $certificate->company_id = $companyId;

        $certificate->expiry_date = $expiry_date;

        if (request()->has('certificate_path')) {
            $certificate->certificate_path = request('certificate_path')->storeAs('certificates', $certificate->training_date . ' ' . $certificate->training->name . ' ' . Carbon::now()->format('His') . '.' . request('certificate_path')->getClientOriginalExtension(), 'public');
        };

        $certificate->save();

        $trainingId = $certificate->training_id;

        return redirect($certificate->userpath($companyId, $trainingId));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy($companyId, $trainingId, Certificate $certificate)
    {
        $company =  Company::findOrfail($companyId);

        $training = Training::findOrfail($trainingId);

        $certificate->delete();

        return redirect()->route('user.certificates.index', [$companyId, $trainingId]);


    }
}
