<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Core\Training\Domain\Repository\TrainingRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCertificateRequest;
use App\Http\Requests\UpdateUserCertificateRequest;
use App\Training;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as IlluminateView;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Safe\DateTime;

use function date;
use function is_array;
use function redirect;
use function route;
use function view;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Certificate::class, 'certificate');
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
        $companyTrainings =  $company->getTrainings();

        $companyEmployees =  $company->getEmployees();

        return view('user.certificates.create', ['companyTrainings' => $companyTrainings, 'company' => $company, 'companyEmployees' => $companyEmployees]);
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function store(TrainingRepositoryInterface $trainingRepository, StoreUserCertificateRequest $request, Company $company, Certificate $certificate)
    {
        $training = $trainingRepository->getById($request->get('training_id'));
        if ($training === null) {
            throw new Exception('No training found!');
        }

        $trainingDate = new DateTime($request->get('training_date'));
        $expiryDate   = $certificate->calculateExpiryDate(new DateTime($request->get('training_date')), $training);
        $uploadedFile = $request->file('file');
        if ($uploadedFile === null || is_array($uploadedFile)) {
            throw new Exception('File not uploaded.');
        }

        $fileName = $this->generateFileName($trainingDate, $training, $company, $uploadedFile);

        $certificatePath = Storage::putFileAs('certificate', $uploadedFile, $fileName);

        if (! $certificatePath === true) {
            throw new Exception('File not saved.');
        }

        $certificate = new Certificate();
        $certificate->setName($fileName);
        $certificate->setPath($certificatePath);
        $certificate->setTrainingDate($trainingDate);
        $certificate->setExpiryDate($expiryDate);
        $certificate->setTraining($training);
        $certificate->setCompany($company);

        $certificate->save();

        $certificate->setEmployees($request->get('employee_ids'));

        return redirect($certificate->userPath($company, $training));
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Company $company, Training $training, Certificate $certificate)
    {
        return view('user.certificates.show', ['certificate' => $certificate, 'company' => $company, 'training' => $training]);
    }

    public function download(Certificate $certificate): string
    {
        return Storage::url('certificates/' . $certificate->getName());
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Company $company, Training $training, Certificate $certificate)
    {
        return view('user.certificates.edit', ['company' => $company, 'companyTrainings' => $company->getTrainings(), 'companyEmployees' => $company->getEmployees(), 'training' => $training, 'certificate' => $certificate]);
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function update(UpdateUserCertificateRequest $request, Company $company, Training $training, Certificate $certificate)
    {
        $trainingDate = new DateTime($request->get('training_date'));
        $expiryDate   = $certificate->calculateExpiryDate(new DateTime($request->get('training_date')), $training);
        $uploadedFile = $request->file('file');
        if ($uploadedFile === null || is_array($uploadedFile)) {
            throw new Exception('File not uploaded.');
        }

        $fileName        = $this->generateFileName($trainingDate, $training, $company, $uploadedFile);
        $certificatePath = Storage::putFileAs('certificate', $uploadedFile, $fileName);

        if (! $certificatePath === true) {
            throw new Exception('File not saved.');
        }

        $certificate->setName($fileName);
        $certificate->setPath($certificatePath);
        $certificate->setTrainingDate($trainingDate);
        $certificate->setExpiryDate($expiryDate);
        $certificate->setTraining($training);
        $certificate->setCompany($company);

        $certificate->save();

        return redirect($certificate->userPath($company, $training));
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function destroy(Company $company, Training $training, Certificate $certificate)
    {
        $certificate->delete();

        return redirect(route('user.certificate.index', ['company' => $company, 'training' => $training]));
    }

    private function generateFileName(DateTime $trainingDate, Training $training, Company $company, UploadedFile $uploadedFile): string
    {
        return $trainingDate->format('Y-m-d') . ' ' . $training->getName() . ' ' . $company->getId() . ' ' . date('is') . '.' . $uploadedFile->getClientOriginalExtension();
    }
}
