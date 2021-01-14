<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Core\Registry\Domain\Repository\RegistryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserReportRequest;
use App\Http\Requests\UpdateUserReportRequest;
use App\Registry;
use App\Report;
use DateTime;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View as IlluminateView;

use function date;
use function is_array;
use function redirect;
use function route;
use function view;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    /**
     * @return Factory|IlluminateView
     *
     * @throws AuthorizationException
     */
    public function create(Company $company, Report $report)
    {
        $this->authorize('update', $report);

        return view('user.reports.create', ['company' => $company]);
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function store(RegistryRepositoryInterface $registryRepository, StoreUserReportRequest $request, Company $company, Report $report)
    {
        $this->authorize('update', $report);

        $registry = $registryRepository->getById($request->get('registry_id'));
        if ($registry === null) {
            throw new Exception('No registry found!');
        }

        $reportDate       = new DateTime($request->get('report_date'));
        $reportExpiryDate = $report->calculateExpiryDate($reportDate, $registry);

        $uploadedFile = $request->file('file');
        if ($uploadedFile === null || is_array($uploadedFile)) {
            throw new Exception('File not uploaded.');
        }

        $fileName = $this->generateFileName($reportDate, $registry, $company, $uploadedFile);

        $reportPath = Storage::putFileAs('reports', $uploadedFile, $fileName);

        if (! $reportPath === true) {
            throw new Exception('File not saved.');
        }

        $report = new Report();
        $report->setExpiryDate($reportExpiryDate);
        $report->setName($fileName);
        $report->setReportDate($reportDate);
        $report->setPath($reportPath);
        $report->setCompany($company);
        $report->setRegistry($registry);
        $report->save();

             return redirect(route('user.registries.index', ['company' => $company]));
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Company $company, Report $report)
    {
        return view('user.reports.show', ['report' => $report, 'company' => $company]);
    }

    public function download(Report $report): string
    {
        return Storage::url('reports/' . $report->getName());
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Company $company, Report $report)
    {
        return view('user.reports.edit', ['report' => $report, 'company' => $company]);
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function update(RegistryRepositoryInterface $registryRepository, UpdateUserReportRequest $request, Company $company, Report $report)
    {
        $registry = $registryRepository->getById($request->get('registry_id'));
        if ($registry === null) {
            throw new Exception('No registry found!');
        }

        $reportDate       = new DateTime($request->get('report_date'));
        $reportExpiryDate = $report->calculateExpiryDate(new DateTime($request->get('report_date')), $registry);

        $uploadedFile = $request->file('file');
        if ($uploadedFile === null || is_array($uploadedFile)) {
            throw new Exception('File not uploaded.');
        }

        $fileName = $this->generateFileName($reportDate, $registry, $company, $uploadedFile);
        $report->setName($fileName);

        $reportPath = Storage::putFileAs('reports', $uploadedFile, $fileName);

        if (! $reportPath === true) {
            throw new Exception('File not saved.');
        }

        $report->setExpiryDate($reportExpiryDate);
        $report->setPath($reportPath);
        $report->setReportDate($reportDate);
        $report->setCompany($company);
        $report->setRegistry($registry);
        $report->save();

        return redirect($registry->userpath($company));
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function destroy(RegistryRepositoryInterface $registryRepository, Company $company, Report $report)
    {
        $registry = $registryRepository->getById((string) $report->getRegistry()->getId());
        if ($registry === null) {
            throw new Exception('No registry found!');
        }

        $report->delete();

        return redirect(route('user.registries.show', ['company' => $company, 'registry' => $registry]));
    }

    private function generateFileName(DateTime $reportDate, Registry $registry, Company $company, UploadedFile $uploadedFile): string
    {
        return $reportDate->format('Y-m-d') . ' ' . $registry->getName() . ' ' . $company->getId() . '-' . date('is') . '.' . $uploadedFile->getClientOriginalExtension();
    }
}
