<?php

namespace App\Http\Controllers\User;

use App\Report;
use App\Http\Controllers\Controller;
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
     * @param \Illuminate\Http\Request $request
     * @param Report $report
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Report $report)
    {
        $this->authorize('update', $report);



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
