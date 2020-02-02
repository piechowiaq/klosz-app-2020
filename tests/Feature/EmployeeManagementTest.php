<?php

namespace Tests\Feature;

use App\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_employees()
    {
        $this->get('/admin/employees/create')->assertRedirect('login');

        $employee = factory(Employee::class)->create();

        $this->post('/admin/employees', $employee->toArray())->assertRedirect('login');

        $this->patch($employee->path())->assertRedirect('/login');

        $this->delete($employee->path())->assertRedirect('/login');

        $this->get($employee->path().'/edit')->assertRedirect('/login');

        $this->get('/admin/employees')->assertRedirect('/login');

        $this->get($employee->path())->assertRedirect('/login');

    }

    /** @test */
    public function a_employee_can_be_created()
    {
        $this->signIn();

        $this->get('/admin/employees/create')->assertStatus(403);

        $this->signInSuperAdmin();

        $response = $this->post('/admin/employees', $attributes = factory(Employee::class)->raw());

        $employee = Employee::all();

        $this->assertCount(1, $employee);

        $employee = Employee::where('id', 1)->first();

        $response->assertRedirect($employee->path());

    }

    /** @test */
    public function a_employee_can_be_updated()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/employees', $attributes = factory(Employee::class)->raw());

        $employee = Employee::first();

        $response = $this->patch($employee->path(), $attributes = [
            'name'=> 'New Name',
        ]);

        $this->get($employee->path().'/edit')->assertOk();

        $this->assertDatabaseHas('employees', $attributes);

        $response->assertRedirect($employee->fresh()->path());
    }

    /** @test */
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

    /** @test */
    public function a_employee_name_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/employees', array_merge($attributes = factory(Employee::class)->raw(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

}
