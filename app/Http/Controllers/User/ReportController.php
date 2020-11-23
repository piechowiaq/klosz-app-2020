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
use Illuminate\Support\Facades\Storage;

use function basename;
use function compact;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    public function index(): void
    {
    }

    public function create($companyId, Report $report)
    {
        $this->authorize('update', $report);

        $report = new Report();

        $company = Company::findOrFail($companyId);

        return view('user.reports.create', compact('report', 'company'));
    }

    public function store(StoreUserReportRequest $request, $companyId, Report $report)
    {
        $this->authorize('update', $report);

        $report = new Report(request(['registry_id', 'report_date']));

        $path = request('file')->storeAs('reports', $report->report_date . ' ' . $report->registry->name . ' ' . $companyId . '-' . Carbon::now()->format('His') . '.' . request('file')->getClientOriginalExtension(), 's3');

        $report->company_id = $companyId;

        $report->expiry_date = $report->calculateExpiryDate(request('report_date'));

        $report->report_name = basename($path);

        $report->report_path = Storage::disk('s3')->url($path);

//        dd(basename(request('report_path')->storeAs('reports', $report->report_date . ' ' . $report->registry->name . ' ' .$companyId.'-'. Carbon::now()->format('His') . '.' . request('report_path')->getClientOriginalExtension(), 's3')));

        $report->save();

        return redirect()->route('user.registries.index', [$companyId]);
    }

    public function show($companyId, Report $report)
    {
        $company = Company::findOrFail($companyId);

        return view('user.reports.show', compact('report', 'company'));
    }

    public function download($companyId, Report $report)
    {
        return Storage::disk('s3')->response('reports/' . $report->report_name);
    }

    public function edit($companyId, Report $report)
    {
        $company = Company::findOrFail($companyId);

        return view('user.reports.edit', compact('report', 'company'));
    }

    public function update(UpdateUserReportRequest $request, $companyId, Report $report)
    {
        $company = Company::findOrfail($companyId);

        $report->update(request(['registry_id', 'report_date']));

        $report->company_id = $companyId;

        $report->expiry_date = Carbon::create(request('report_date'))->addMonths(Registry::where('id', $report->registry_id)->first()->valid_for)->toDateString();

        if (request()->has('file')) {
            $path = request('file')->storeAs('reports', $report->report_date . ' ' . $report->registry->name . ' ' . $companyId . '-' . Carbon::now()->format('His') . '.' . request('file')->getClientOriginalExtension(), 's3');

            $report->report_name = basename($path);

            $report->report_path = Storage::disk('s3')->url($path);
        }

        $report->save();

        $registry = Registry::where('id', $report->registry_id)->first();

        return redirect($registry->userpath($companyId));
    }

    public function destroy($companyId, Report $report)
    {
        $registry = Registry::where('id', $report->registry_id)->first();

        $report->delete();

        return redirect($registry->userpath($companyId));
    }
}
