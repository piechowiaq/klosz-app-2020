<?php

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCertificateRequest;
use App\Http\Requests\UpdateUserCertificateRequest;
use App\Training;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use function basename;
use function compact;
use function redirect;
use function request;
use function view;

class CertificateController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    public function index($companyId, $trainingId): Renderable
    {
        $company = Company::findOrfail($companyId);
        $training = Training::findOrfail($trainingId);

        return \view('user.certificates.index', \compact('training', 'company'));
    }


    public function create(Company $company, Certificate $certificate): Response
    {
        $this->authorize('update', $certificate);

        $certificate = new Certificate;

        $companyTrainings = $company->trainings;

        $companyEmployees = $company->employees;

        return view(
            'user.certificates.create',
            compact( 'companyTrainings', 'certificate', 'company', 'companyEmployees'),
        );
    }

    public function store(StoreUserCertificateRequest $request, $companyId, Certificate $certificate ): void
    {
        $this->authorize('update', $certificate);

        $expiry_date = Carbon::create(\request('training_date'))->addMonths(
            Training::where('id', request('training_id'))->first()->valid_for,
        )->toDateString();

        $certificate = new Certificate(request(['training_id', 'training_date']));

        $certificate->company_id = $companyId;

        $certificate->expiry_date = $expiry_date;

        $path = request('file')->storeAs(
            'certificates',
            $certificate->training_date . ' ' . $certificate->training->name . ' ' .$companyId. '-' . Carbon::now()->format(
                'His',
            ) . '.' . request(
                'file',
            )->getClientOriginalExtension(),
            's3',
        );

        $certificate->certificate_name = \basename($path);

        $certificate->certificate_path = Storage::disk('s3')->url($path) ;

        $certificate->save();

        $certificate->employees()->sync(request('employee_id'));

        $trainingId = $certificate->training_id;

        return \redirect($certificate->userpath($companyId, $trainingId));
    }

    public function show($companyId, $trainingId, Certificate $certificate): Response
    {
        $company = Company::findOrFail($companyId);

        $training = Training::where($trainingId, $certificate->training_id);

        return view('user.certificates.show', compact('certificate', 'company','training'));
    }

    public function download($companyId, Certificate $certificate)
    {
        return Storage::disk('s3')->response('certificates/'. $certificate->certificate_name);
    }

    public function edit($companyId, $trainingId, Certificate $certificate): void
    {
        $this->authorize('update', $certificate);

        $company = Company::findOrfail($companyId);

        $training = Training::findOrfail($trainingId);

        $companyTrainings = $company->trainings;

        $companyEmployees = $company->employees;

        return view (
            'user.certificates.edit',
            compact('company', 'companyTrainings', 'companyEmployees','training', 'certificate'),
        );
    }
    public function update(
        UpdateUserCertificateRequest $request,
        $companyId,
        $trainingId,
        Certificate $certificate
    ): Response
    {
        $this->authorize('update', $certificate);

        $expiry_date = Carbon::create(request('training_date'))->addMonths(
            Training::where('id', $trainingId)->first()->valid_for,
        )->toDateString();

        $certificate->update(request(['training_id', 'training_date']));

        $certificate->company_id = $companyId;

        $certificate->expiry_date = $expiry_date;

        if (request()->has('file')) {
            $path = request('file')->storeAs(
                'certificates',
                $certificate->training_date . ' ' . $certificate->training->name . ' ' .$companyId.'-' . Carbon::now()->format(
                    'His',
                ) . '.' . request(
                    'file',
                )->getClientOriginalExtension(),
                's3',
            );

            $certificate->certificate_name = basename($path);

            $certificate->certificate_path = Storage::disk('s3')->url($path) ;}

        $certificate->save();

        $certificate->employees()->sync(request('employee_id'));

        $trainingId = $certificate->training_id;

        return redirect($certificate->userpath($companyId, $trainingId));
    }

    public function destroy($companyId, $trainingId, Certificate $certificate): Response
    {
        $certificate->delete();

        return redirect()->route('user.certificates.index', [$companyId, $trainingId]);
    }

}
