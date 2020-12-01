<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCertificateRequest;
use App\Http\Requests\UpdateUserCertificateRequest;
use App\Training;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

use function basename;
use function redirect;
use function request;
use function view;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    public function index(Company $company, Training $training): Renderable
    {
        return view('user.certificates.index')->with(['training' => $training, 'company' => $company]);
    }

    public function create(Company $company, Certificate $certificate): Renderable
    {
        $this->authorize('update', $certificate);

        $certificate = new Certificate();

        $companyTrainings =  $company->getTrainings();

        $companyEmployees =  $company->getEmployees();

        return view('user.certificates.create')->with(['companyTrainings' => $companyTrainings, 'certificate' => $certificate, 'company' => $company, 'companyEmployees' => $companyEmployees]);
    }

    public function store(StoreUserCertificateRequest $request, Company $company, Certificate $certificate): RedirectResponse
    {
        $this->authorize('update', $certificate);

        $expiry_date = Carbon::create(request('training_date'))->addMonths(Training::where('id', request('training_id'))->first()->valid_for)->toDateString();

        $certificate = new Certificate(request(['training_id', 'training_date']));

        $certificate->company_id = $company->getId();

        $certificate->expiry_date = $expiry_date;

        $path = request('file')->storeAs('certificates', $certificate->training_date . ' ' . $certificate->training->name . ' ' . $company->getId() . '-' . Carbon::now()->format('His') . '.' . request('file')->getClientOriginalExtension(), 's3');

        $certificate->certificate_name = basename($path);

        $certificate->certificate_path = Storage::disk('s3')->url($path);

        $certificate->save();

        $certificate->employees()->sync(request('employee_id'));

        $trainingId = $certificate->training_id;

        return redirect($certificate->userpath($company->getId(), $trainingId));
    }

    public function show(Company $company, Training $training, Certificate $certificate): Renderable
    {
        $training = Training::where($training->id, $certificate->training_id);

        return view('user.certificates.show')->with(['certificate' => $certificate, 'company' => $company, 'training' => $training]);
    }

    public function download(Company $company, Certificate $certificate): StreamedResponse
    {
        return Storage::disk('s3')->response('certificates/' . $certificate->certificate_name);
    }

    public function edit(Company $company, Training $training, Certificate $certificate): Renderable
    {
        $this->authorize('update', $certificate);

        $companyTrainings =  $company->getTrainings();

        $companyEmployees =  $company->getEmployees();

        return view('user.certificates.edit')->with(['company' => $company, 'companyTrainings' => $companyTrainings, 'companyEmployees' => $companyEmployees, 'training' => $training, 'certificate' => $certificate]);
    }

    public function update(UpdateUserCertificateRequest $request, Company $company, Training $training, Certificate $certificate): RedirectResponse
    {
        $this->authorize('update', $certificate);

        $expiry_date = Carbon::create(request('training_date'))->addMonths(Training::where('id', $training->id)->first()->valid_for)->toDateString();

        $certificate->update(request(['training_id', 'training_date']));

        $certificate->company_id = $company->getId();

        $certificate->expiry_date = $expiry_date;

        if (request()->has('file')) {
            $path = request('file')->storeAs('certificates', $certificate->training_date . ' ' . $certificate->training->name . ' ' . $company->getId() . '-' . Carbon::now()->format('His') . '.' . request('file')->getClientOriginalExtension(), 's3');

            $certificate->certificate_name = basename($path);

            $certificate->certificate_path = Storage::disk('s3')->url($path);
        }

        $certificate->save();

        $certificate->employees()->sync(request('employee_id'));

        $training = $certificate->training_id;

        return redirect($certificate->userpath($company->getId(), $training));
    }

    public function destroy(Company $company, Training $training, Certificate $certificate): RedirectResponse
    {
        $certificate->delete();

        return redirect()->route('user.certificates.index', [$company->getId(), $training]);
    }
}
