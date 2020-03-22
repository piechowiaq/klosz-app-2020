<?php

namespace Tests\Feature;

use App\Certificate;
use App\Training;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CertificateManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_certificates()
    {
        $this->get('/admin/certificates/create')->assertRedirect('login');

        $certificate = factory(Certificate::class)->create();

        $this->post('/admin/certificates', $certificate->toArray())->assertRedirect('login');

        $this->patch($certificate->path())->assertRedirect('/login');

        $this->delete($certificate->path())->assertRedirect('/login');

        $this->get($certificate->path().'/edit')->assertRedirect('/login');

        $this->get('/admin/certificates')->assertRedirect('/login');

        $this->get($certificate->path())->assertRedirect('/login');

    }

    /** @test */
    public function a_certificate_can_be_created()
    {


       $this->signIn();

        $this->get('/admin/certificates/create')->assertStatus(403);

        $response = $this->post('/admin/certificates', $attributes = factory(Certificate::class)->raw());

        $certificate = Certificate::all();

        $this->assertCount(0, $certificate);

        $this->signInSuperAdmin();

        $this->get('/admin/certificates/create')->assertOk();

        $response = $this->post('/admin/certificates', $attributes = factory(Certificate::class)->raw());

        $certificate = Certificate::all();

        $this->assertCount(1, $certificate);

        $certificate = Certificate::where('id', 1)->first();

        $response->assertRedirect($certificate->path());

    }

    /** @test */
    public function a_employee_can_be_updated()
    {
        //$this->withoutExceptionHandling();

        $training = factory(Training::class)->create();

        $certificate = factory(Certificate::class)->create();


        $this->signIn();

        $this->get('/admin/certificates/create')->assertStatus(403);


        $response = $this->patch($certificate->path(), $attributes = [
            'training_id'=> 2,
        ]);

        $this->get($certificate->path().'/edit')->assertStatus(403);

        $this->assertDatabaseHas('certificates', $attributes = [
            'training_id'=> 1,
        ]);



        $this->signInSuperAdmin();

        $this->get('/admin/certificates/create')->assertOk();

        $response = $this->post('/admin/certificates', $attributes = factory(Certificate::class)->raw());

        $certificate = Certificate::first();

        $response = $this->patch($certificate->path(), $attributes = [
            'training_id'=> 2,
        ]);

        $this->get($certificate->path().'/edit')->assertOk();

        $this->assertDatabaseHas('certificates', $attributes);

        $response->assertRedirect($certificate->fresh()->path());
    }


    public function a_employee_can_be_deleted()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/employees', $attributes = factory(Employee::class)->raw());

        $employee = Employee::first();

        $this->assertCount(1, Employee::all());

        $response = $this->delete($employee->path());

        $this->assertCount(0, Employee::all());

        $response->assertRedirect('/admin/employees');

    }


    public function a_employee_name_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/employees', array_merge($attributes = factory(Employee::class)->raw(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

}
