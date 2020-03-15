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

    /** @test */
    public function guests_cannot_manage_employees()
    {
        $this->get('/companies/{company}/employees/create')->assertRedirect('/login');

        $employee = factory(Employee::class)->create();

        $this->post('/companies/{company}/employees', $employee->toArray())->assertRedirect('/login');

        $this->patch($employee->userpath(1))->assertRedirect('/login');

        $this->delete($employee->userpath(1))->assertStatus(405);

        $this->get($employee->userpath(1).'/edit')->assertRedirect('/login');

        $this->get('/companies/{company}/employees')->assertRedirect('/login');

        $this->get($employee->userpath(1))->assertRedirect('/login');

    }
    /** @test */
    public function signIn_user_with_no_company_cannot_manage_employees()
    {
        $this->signIn();

        $this->get('/companies/{company}/employees/create')->assertRedirect('/login');

        $employee = factory(Employee::class)->create();

        $this->post('/companies/{company}/employees', $employee->toArray())->assertRedirect('/login');

        $this->patch($employee->userpath(1))->assertRedirect('/login');

        $this->delete($employee->userpath(1))->assertStatus(405);

        $this->get($employee->userpath(1).'/edit')->assertRedirect('/login');

        $this->get('/companies/{company}/employees')->assertRedirect('/login');

        $this->get($employee->userpath(1))->assertRedirect('/login');

    }

    /** @test */
    public function signedInUser_can_only_access_their_company_employees()
    {
        $this->signInUser();

        $response = $this->get('/companies/1/employees');

        $response->assertOk();

        $response = $this->get('/companies/2/employees');

        $response->assertRedirect('/login');

    }

    /** @test */
    public function an_employee_can_be_created_by_signedInManager()
    {

//        $this->signInUser();
//
//        $this->get('/companies/1/employees/create')->assertStatus(403);

        $this->signInManager();

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
        $this->withoutExceptionHandling();

        $this->signInManager();

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







}
