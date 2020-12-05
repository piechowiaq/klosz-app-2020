<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCertificateRequest;
use App\Http\Requests\UpdateUserCertificateRequest;
use App\Training;
use DateTime;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View as IlluminateView;
use Symfony\Component\HttpFoundation\StreamedResponse;

use function date;
use function redirect;
use function request;
use function view;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function index(Company $company, Training $training)
    {
        return view('user.certificates.index', ['training' => $training, 'company' => $company]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create(Company $company, Certificate $certificate)
    {
        $this->authorize('update', $certificate);

        $certificate = new Certificate();

        $companyTrainings =  $company->getTrainings();

        $companyEmployees =  $company->getEmployees();

        return view('user.certificates.create', ['companyTrainings' => $companyTrainings, 'certificate' => $certificate, 'company' => $company, 'companyEmployees' => $companyEmployees]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function store(StoreUserCertificateRequest $request, Company $company, Certificate $certificate)
    {
        $this->authorize('update', $certificate);

        $training = Training::getTrainingById($request->get('training_id'));

        $trainingDate = new DateTime($request->get('training_date'));
        $expiryDate   = $certificate->calculateExpiryDate(new DateTime($request->get('training_date')), $training);
        $fileName     = $trainingDate->format('Y-m-d') . ' ' . $training->getName() . ' ' . $company->getId() . ' ' . date('is') . '.' . request('file')->getClientOriginalExtension();
        $path         = request('file')->storeAs('certificates', $fileName, 's3');

        $certificate = new Certificate();
        $certificate->setName($fileName);
        $certificate->setPath(Storage::disk('s3')->url($path));
        $certificate->setTrainingDate($trainingDate);
        $certificate->setExpiryDate($expiryDate);
        $certificate->setTraining($training);
        $certificate->setCompany($company);
        $certificate->save();

        $certificate->setEmployees($request->get('employee_id'));

        return redirect($certificate->userPath($company, $training));
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Company $company, Training $training, Certificate $certificate)
    {
        return view('user.certificates.show', ['certificate' => $certificate, 'company' => $company, 'training' => $training]);
    }

    public function download(Company $company, Certificate $certificate): StreamedResponse
    {
        return Storage::disk('s3')->response('certificates/' . $certificate->getName());
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Company $company, Training $training, Certificate $certificate)
    {
        $this->authorize('update', $certificate);

        return view('user.certificates.edit', ['company' => $company, 'companyTrainings' => $company->getTrainings(), 'companyEmployees' => $company->getEmployees(), 'training' => $training, 'certificate' => $certificate]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function update(UpdateUserCertificateRequest $request, Company $company, Training $training, Certificate $certificate)
    {
        $this->authorize('update', $certificate);

        $trainingDate = new DateTime($request->get('training_date'));
        $expiryDate   = $certificate->calculateExpiryDate(new DateTime($request->get('training_date')), $training);

        $certificate->update(request(['training_id', 'training_date']));

        $certificate->setCompany($company);
        if (request()->has('file')) {
            $fileName = $trainingDate->format('Y-m-d') . ' ' . $training->getName() . ' ' . $company->getId() . ' ' . date('is') . '.' . request('file')->getClientOriginalExtension();
            $path     = request('file')->storeAs('certificates', $fileName, 's3');
            $certificate->setName($fileName);
            $certificate->setPath(Storage::disk('s3')->url($path));
        }

        $certificate->setExpiryDate($expiryDate);
        $certificate->save();

        $certificate->setEmployees($request->get('employee_id'));

        return redirect($certificate->userPath($company, $training));
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function destroy(Company $company, Training $training, Certificate $certificate)
    {
        $certificate->delete();

        return redirect()->route('user.certificates.index', [$company->getId(), $training]);
    }
}
