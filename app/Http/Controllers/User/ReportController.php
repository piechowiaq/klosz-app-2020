<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserReportRequest;
use App\Http\Requests\UpdateUserReportRequest;
use App\Registry;
use App\Report;
use DateTime;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View as IlluminateView;
use Symfony\Component\HttpFoundation\StreamedResponse;

use function redirect;
use function view;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create(Company $company, Report $report)
    {
        $this->authorize('update', $report);

        $report = new Report();

        return view('user.reports.create', ['report' => $report, 'company' => $company]);
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function store(StoreUserReportRequest $request, Company $company, Report $report)
    {
        $this->authorize('update', $report);

        $registry = Registry::getRegistryById($request->get('registry_id'));
        if ($registry === null) {
            throw new Exception('No registry found!');
        }

        $report = new Report();
        $report->setReportDate(new DateTime($request->get('report_date')));
        $report->setName($registry, $company, $request);
        if ($request->file('file') === null) {
            throw new Exception('No file found!');
        }

        $report->setPath(Storage::disk('s3')->url($request->file('file')->storeAs('reports', $report->getName(), 's3')));
        $report->setExpiryDate($report->calculateExpiryDate($report->getReportDate(), $registry));
        $report->setCompany($company);
        $report->setRegistry($registry);
        $report->save();

        return redirect($company->getId() . '/registries');
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Company $company, Report $report)
    {
        return view('user.reports.show', ['report' => $report, 'company' => $company]);
    }

    public function download(Company $company, Report $report): StreamedResponse
    {
        return Storage::disk('s3')->response('reports/' . $report->getName());
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
    public function update(UpdateUserReportRequest $request, Company $company, Report $report)
    {
        $registry = Registry::getRegistryById($request->get('registry_id'));
        if ($registry === null) {
            throw new Exception('No registry found!');
        }

        $report->setReportDate(new DateTime($request->get('report_date')));

        if (! empty($request->file('file'))) {
            $report->setName($registry, $company, $request);
            $report->setPath(Storage::disk('s3')->url($request->file('file')->storeAs('reports', $report->getName(), 's3')));
        }

        $report->setExpiryDate($report->calculateExpiryDate($report->getReportDate(), $registry));
        $report->setCompany($company);
        $report->setRegistry($registry);
        $report->save();

        return redirect($registry->userpath($company));
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function destroy(Company $company, Report $report)
    {
        $registry = Registry::getRegistryById((string) $report->getRegistry()->pluck('id')->toArray()[0]);
        if ($registry === null) {
            throw new Exception('No registry found!');
        }

        $report->delete();

        return redirect($company->getId() . '/registries/' . $registry->getID());
    }
}
