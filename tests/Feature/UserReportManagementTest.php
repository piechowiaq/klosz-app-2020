<?php

namespace Tests\Feature;

use App\Registry;
use App\Report;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

        Storage::fake('public');

        $response = $this->post('/1/reports', factory(Report::class)->raw());

        $this->assertCount(1, Report::all());

        $report = Report::first();

        Storage::disk('public')->assertExists('reports/'. $report->report_date . ' ' . $report->registry->name . ' ' . Carbon::now()->format('His') . '.' . request('report_path')->getClientOriginalExtension());

        $response->assertRedirect('/1/registries');
    }

    /** @test */
    public function a_report_can_be_created_by_signInAdmin()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        Storage::fake('public');

        $response = $this->post('/1/reports', factory(Report::class)->raw());

        $this->assertCount(1, Report::all());

        $report = Report::first();

        Storage::disk('public')->assertExists('reports/'. $report->report_date . ' ' . $report->registry->name . ' ' . Carbon::now()->format('His') . '.' . request('report_path')->getClientOriginalExtension());

        $response->assertRedirect('/1/registries');
    }

    /** @test */
    public function a_report_can_be_edited_by_signInAdmin()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $report = factory(Report::class)->create();

        $this->get($report->userpath(1).'/edit')->assertOk();

        $response = $this->patch($report->userpath(1), $attributes = [
            'report_date'=> '1984-08-03',
        ]);

        $this->assertDatabaseHas('reports', $attributes);

        $registry = Registry::where('id', $report->registry_id)->first();

        $response->assertRedirect($registry->userpath(1));

    }

    /** @test */
    public function a_report_uploaded_file_can_be_edited_by_signInAdmin()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        Storage::fake('public');

        $report = factory(Report::class)->create();

        $response = $this->patch($report->userpath(1), $attributes = [
            'report_path'=> UploadedFile::fake()->image('report.jpg'),
        ]);

        Storage::disk('public')->assertExists('reports/'. $report->report_date . ' ' . $report->registry->name . ' ' . Carbon::now()->format('His') . '.' . request('report_path')->getClientOriginalExtension());

    }


    /** @test */
    public function a_report_can_be_destroyed_by_signInAdmin()
    {
        $this->signInAdmin();

        $report = factory(Report::class)->create();

        $registry = Registry::where('id', $report->registry_id)->first();

        $response = $this->delete($report->userpath(1));

        $this->assertCount(0, Report::all());

        $response->assertRedirect($registry->userpath(1));

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

    /** @test */
    public function a_report_requires_a_report_path()
    {
        $this->signInManager();

        $this->post('/1/reports', factory(Report::class)->raw(['report_path' => '']))->assertSessionHasErrors('report_path');
    }
}


