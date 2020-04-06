<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserReportManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_reports()
    {
        $this->withoutExceptionHandling();

        $this->get('/{company}/reports/create')->assertRedirect('/login');

        $report = factory(Report::class)->create();

        $this->post('/{company}/reports', factory(Report::class)->raw())->assertRedirect('login');

        $this->get($report->path())->assertRedirect('/login');

    }
}
