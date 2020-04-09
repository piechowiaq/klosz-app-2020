<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\StoreUserReportRequest;
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
    public function create(Report $report)
    {
        $this->authorize('update', $report);


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

        $report->save();

        return redirect($report->userpath($companyId));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
