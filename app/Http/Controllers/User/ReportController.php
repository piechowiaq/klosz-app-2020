<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserReportRequest;
use App\Http\Requests\UpdateUserReportRequest;
use App\Registry;
use App\Report;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View as IlluminateView;
use Symfony\Component\HttpFoundation\StreamedResponse;

use function basename;
use function redirect;
use function request;
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

    public function store(StoreUserReportRequest $request, Company $company, Report $report): RedirectResponse
    {
        $this->authorize('update', $report);

        $report   = new Report();
        $registry = Registry::getRegistryById($request->get('registry_id'));
        if ($registry === null) {
            throw new Exception('No registry found!');
        }

        $report->setRegistry($registry);
        $report->setReportDate(new DateTime($request->get('report_date')));

        $fileName = $report->getReportDate()->format('Y-m-d') . ' ' . $report->getRegistry()->getName() . ' ' . $company->getId() . '-' . (new DateTime())->format('His') . '.' . $request->get('file')->getClientOriginalExtension();
        $path     = $request->get('file')->storeAs('reports', $fileName, 's3');

        $report->setCompany($company);

        $report->setExpiryDate($this->calculateExpiryDate($request->get('report_date'), $registry));

        $report->setName(basename($path));

        $report->setPath(Storage::disk('s3')->url($path));

//        dd(basename(request('report_path')->storeAs('reports', $report->report_date . ' ' . $report->registry->name . ' ' .$companyId.'-'. Carbon::now()->format('His') . '.' . request('report_path')->getClientOriginalExtension(), 's3')));

        $report->save();

        return redirect()->route('user.registries.index', [$company]);
    }

    private function calculateExpiryDate(DateTime $reportDate, Registry $registry): DateTime
    {
        $monthsToAdd = $registry->getValidFor();

        return $reportDate->modify('+' . $monthsToAdd . ' month');
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

    public function update(UpdateUserReportRequest $request, Company $company, Report $report): RedirectResponse
    {
        $report->update(request(['registry_id', 'report_date']));

        $report->setCompany($company);

        $report->expiry_date = Carbon::create(request('report_date'))->addMonths(Registry::where('id', $report->registry_id)->first()->valid_for)->toDateString();

        if (request()->has('file')) {
            $path = request('file')->storeAs('reports', $report->report_date . ' ' . $report->registry->name . ' ' . $company->getId() . '-' . Carbon::now()->format('His') . '.' . request('file')->getClientOriginalExtension(), 's3');

            $report->setName(basename($path));

            $report->setPath(Storage::disk('s3')->url($path));
        }

        $report->save();

        $registry = Registry::where('id', $report->registry_id)->first();

        return redirect($registry->userpath($company));
    }

    public function destroy(Company $company, Report $report): RedirectResponse
    {
        $registry = Registry::where('id', $report->registry_id)->first();

        $report->delete();

        return redirect($registry->userpath($company));
    }
}
