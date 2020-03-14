<?php

namespace Tests\Feature;

use App\Company;
use App\Employee;
use App\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserEmployeeManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function guests_cannot_manage_employees()
    {
        $this->get('/companies/{company}/employees/create')->assertRedirect('login');

        $employee = factory(Employee::class)->create();

        $this->post('/companies/{company}/employees', $employee->toArray())->assertRedirect('login');

    }

    /** @test */
    public function an_employee_can_be_created()
    {
        $this->signIn();

        $response = $this->post('/companies/1/employees', $attributes = factory(Employee::class)->raw([
            'company_id' => 1,
        ]));

        $employee = Employee::all();

        $this->assertCount(1, $employee);

        $employee = Employee::where('id', 1)->first();

        $response->assertRedirect($employee->userpath(1));

    }

    /** @test */
    public function a_employee_can_be_updated()
    {
        $this->signIn();

        $response = $this->post('/companies/1/employees', $attributes = factory(Employee::class)->raw([
            'company_id' => 1,
        ]));

        $employee = Employee::first();

        $response = $this->patch($employee->userpath(1), $attributes = [
            'name'=> 'New Name',
        ]);

        $this->get($employee->userpath(1).'/edit')->assertOk();

        $this->assertDatabaseHas('employees', $attributes);

        $response->assertRedirect($employee->fresh()->userpath(1));
    }

    /** @test */
    public function user_cannot_access_other_companies_employees()
    {
        $this->signIn();

        $response = $this->get('/companies/1/employees');

        $response->assertOk();

        $response = $this->get('/companies/2/employees');

        $response->assertRedirect('home');

    }





}
