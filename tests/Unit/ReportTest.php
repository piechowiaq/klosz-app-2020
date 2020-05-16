<?php

namespace Tests\Unit;

use App\Registry;
use App\Report;
use App\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function report_has_a_userpath()
    {
        $this->withoutExceptionHandling();

        $report = factory(Report::class)->create();

        $this->signInManager();

        $this->assertEquals("/1/reports/{$report->id}", $report->userpath(1));
    }

    /** @test */
    public function a_certificate_has_a_training()
    {
        $registry= factory(Registry::class)->create();
        $report = factory(Report::class)->create(['registry_id' => $registry->id]);

        $this->assertEquals($report->registry->id, $registry->id);
    }

    /** @test */
    public function a_certificate_has_a_company()
    {
        $company = factory(Company::class)->create();
        $report = factory(Report::class)->create(['company_id' => $company->id]);

        $this->assertEquals($report->company->id, $company->id);
    }
}
