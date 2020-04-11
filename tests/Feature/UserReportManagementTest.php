<?php

namespace Tests\Feature;

use App\Registry;
use App\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserReportManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_reports()
    {
        $this->get('/{company}/reports/create')->assertRedirect('/login');

        $this->post('/{company}/reports', factory(Report::class)->raw())->assertRedirect('login');

        $report = factory(Report::class)->create();

        $this->get($report->userpath(1))->assertRedirect('/login');
    }

    /** @test */
    public function authorised_users_cannot_manage_reports_of_other_companies()
    {
        $this->signInUser();

        $this->get('/2/reports/create')->assertRedirect('/login');

        $this->post('/2/reports', factory(Report::class)->raw())->assertRedirect('login');

        $report = factory(Report::class)->create();

        $this->get($report->userpath(2))->assertRedirect('/login');
    }

    /** @test */
    public function a_report_cannot_be_created_by_signInUser()
    {
        $this->signInUser();

        $this->get('/1/reports/create')->assertStatus(403);

        $this->post('/1/reports', factory(Report::class)->raw())->assertStatus(403);

        $this->assertCount(0, Report::all());
    }

    /** @test */
    public function signInUser_can_access_reports_show_route_of_their_company()
    {
        $this->signInUser();

        $report = factory(Report::class)->create();

        $this->get($report->userpath(1))->assertOk();
    }

    /** @test */
    public function signInManager_can_access_get_reports_routes_of_their_company()
    {
        $this->signInManager();

        $this->get('/1/reports/create')->assertOk();

        $report = factory(Report::class)->create();

        $this->get($report->userpath(1))->assertOk();
    }

    /** @test */
    public function signInAdmin_can_access_get_reports_routes_of_their_company()
    {
        $this->signInAdmin();

        $this->get('/1/reports/create')->assertOk();

        $report = factory(Report::class)->create();

        $this->get($report->userpath(1))->assertOk();
    }

    /** @test */
    public function a_report_can_be_created_by_signInManager()
    {
        $this->withoutExceptionHandling();

        $this->signInManager();

        $response = $this->post('/1/reports', factory(Report::class)->raw());

        $this->assertCount(1, Report::all());

        $report = Report::first();

        $response->assertRedirect($report->userpath(1));
    }

    /** @test */
    public function a_report_can_be_created_by_signInAdmin()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $response = $this->post('/1/reports', factory(Report::class)->raw());

        $this->assertCount(1, Report::all());

        $report = Report::first();

        $response->assertRedirect($report->userpath(1));
    }

    
    /** @test */
    public function a_report_requires_a_registry_id()
    {
        $this->signInManager();

        $this->post('/1/reports', factory(Report::class)->raw(['registry_id' => '']))->assertSessionHasErrors('registry_id');
    }

    /** @test */
    public function a_report_requires_a_company_id()
    {
        $this->signInManager();

        $this->post('/1/reports', factory(Report::class)->raw(['company_id' => '']))->assertSessionHasErrors('company_id');
    }

    /** @test */
    public function a_report_requires_a_report_date()
    {
        $this->signInManager();

        $this->post('/1/reports', factory(Report::class)->raw(['report_date' => '']))->assertSessionHasErrors('report_date');
    }

    /** @test */
    public function a_report_requires_an_expiry_date()
    {
        $this->signInManager();

        $this->post('/1/reports', factory(Report::class)->raw(['expiry_date' => '']))->assertSessionHasErrors('expiry_date');
    }
}
