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
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
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

    public function create(Company $company, Report $report): Renderable
    {
        $this->authorize('update', $report);

        $report = new Report();

        return view('user.reports.create')->with(['report' => $report, 'company' => $company]);
    }

    public function store(StoreUserReportRequest $request, Company $company, Report $report): RedirectResponse
    {
        $this->authorize('update', $report);

        $report = new Report(request(['registry_id', 'report_date']));

        $path = request('file')->storeAs('reports', $report->report_date . ' ' . $report->registry->name . ' ' . $company->getId() . '-' . Carbon::now()->format('His') . '.' . request('file')->getClientOriginalExtension(), 's3');

        $report->company_id = $company->getId();

        $report->expiry_date = $report->calculateExpiryDate(request('report_date'));

        $report->report_name = basename($path);

        $report->report_path = Storage::disk('s3')->url($path);

//        dd(basename(request('report_path')->storeAs('reports', $report->report_date . ' ' . $report->registry->name . ' ' .$companyId.'-'. Carbon::now()->format('His') . '.' . request('report_path')->getClientOriginalExtension(), 's3')));

        $report->save();

        return redirect()->route('user.registries.index', [$company]);
    }

    public function show(Company $company, Report $report): Renderable
    {
        return view('user.reports.show')->with(['report' => $report, 'company' => $company]);
    }

    public function download(Company $company, Report $report): StreamedResponse
    {
        return Storage::disk('s3')->response('reports/' . $report->report_name);
    }

    public function edit(Company $company, Report $report): Renderable
    {
        return view('user.reports.edit')->with(['report' => $report, 'company' => $company]);
    }

    public function update(UpdateUserReportRequest $request, Company $company, Report $report): RedirectResponse
    {
        $report->update(request(['registry_id', 'report_date']));

        $report->company_id = $company->getId();

        $report->expiry_date = Carbon::create(request('report_date'))->addMonths(Registry::where('id', $report->registry_id)->first()->valid_for)->toDateString();

        if (request()->has('file')) {
            $path = request('file')->storeAs('reports', $report->report_date . ' ' . $report->registry->name . ' ' . $company->getId() . '-' . Carbon::now()->format('His') . '.' . request('file')->getClientOriginalExtension(), 's3');

            $report->report_name = basename($path);

            $report->report_path = Storage::disk('s3')->url($path);
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
