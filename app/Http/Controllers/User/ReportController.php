<?php

namespace App\Http\Controllers\User;

use App\Company;
use App\Http\Requests\StoreUserReportRequest;
use App\Http\Requests\UpdateUserReportRequest;
use App\Registry;
use App\Report;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Report $report
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($companyId, Report $report)
    {
        $this->authorize('update', $report);

        $report = new Report();

        $company = Company::findOrFail($companyId);

        return view('user.reports.create', compact( 'report', 'company'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserReportRequest $request
     * @param $companyId
     * @param Report $report
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreUserReportRequest $request, $companyId, Report $report)
    {
        $this->authorize('update', $report);

        //$expiry_date = Carbon::create(request('report_date'))->addMonths( Registry::where('id', request('registry_id'))->first()->valid_for)->toDateString();

        $report = new Report(request(['registry_id', 'report_date']));

        $report->company_id = $companyId;

        $report->expiry_date = $report->calculateExpiryDate(request('report_date'));

        $report->report_path = request('report_path')->storeAs('reports', $report->report_date . ' ' . $report->registry->name . ' ' . Carbon::now()->format('His') . '.' . request('report_path')->getClientOriginalExtension(), 'public');

        $report->save();

        return redirect()->route('user.registries.index', [$companyId]);
    }

    /**
     * Display the specified resource.
     *
     * @param $companyId
     * @param \App\Report $report
     * @return void
     */
    public function show($companyId, Report $report)
    {
        $company = Company::findOrFail($companyId);

        return view('user.reports.show', compact('report', 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit($companyId, Report $report)
    {
        $company = Company::findOrFail($companyId);

        return view('user.reports.edit', compact('report', 'company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserReportRequest $request, $companyId, Report $report)
    {
        $company = Company::findOrfail($companyId);

        $report->update(request(['registry_id', 'report_date']));

        $report->company_id = $companyId;

        $report->expiry_date = Carbon::create(request('report_date'))->addMonths(Registry::where('id', $report->registry_id)->first()->valid_for)->toDateString();

        if (request()->has('report_path')) {
            $report->report_path = request('report_path')->storeAs('reports', $report->report_date . ' ' . $report->registry->name . ' ' . Carbon::now()->format('His') . '.' . request('report_path')->getClientOriginalExtension(), 'public');
        };

        $report->save();

        $registry = Registry::where('id', $report->registry_id)->first();

        return redirect($registry->userpath($companyId));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy($companyId, Report $report)
    {

        $registry = Registry::where('id', $report->registry_id)->first();

        $report->delete();

        return redirect($registry->userpath($companyId));
    }
}
