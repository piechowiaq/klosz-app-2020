<?php

namespace Tests\Unit;


use App\Certificate;
use App\Employee;
use App\Training;
use App\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class CertificateTest extends TestCase
{use RefreshDatabase;
    /** @test */
    public function certificate_belongs_to_many_employees()
    {
        $employee = factory(Employee::class)->create();

        $certificate = factory(Certificate::class)->create();

        $certificate->employees()->sync($employee);

        $this->assertDatabaseHas('certificate_employee', [
            'certificate_id' => $certificate->id,
            'employee_id' => $employee->id
        ]);
    }

    /** @test */
    function certificate_has_a_path()
    {
        $certificate = factory(Certificate::class)->create();

        $this->assertEquals("/admin/certificates/{$certificate->id}", $certificate->path());
    }


    /** @test */
    public function a_certificate_has_a_training()
    {
        $training= factory(Training::class)->create();
        $certificate = factory(Certificate::class)->create(['training_id' => $training->id]);

        $this->assertEquals($certificate->training->id, $training->id);
    }

    /** @test */
    public function a_certificate_has_a_company()
    {
        $company = factory(Company::class)->create();
        $certificate = factory(Certificate::class)->create(['company_id' => $company->id]);

        $this->assertEquals($certificate->company->id, $company->id);
    }




}
