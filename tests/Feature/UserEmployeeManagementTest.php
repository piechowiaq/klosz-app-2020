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


    public function guests_cannot_manage_employees()
    {
        $this->get('/{company}/employees/create')->assertRedirect('/login');

        $employee = factory(Employee::class)->create();

        $this->post('/{company}/employees', $employee->toArray())->assertRedirect('/login');

        $this->patch($employee->userpath(1))->assertRedirect('/login');

        $this->delete($employee->userpath(1))->assertRedirect('/login');

        $this->get($employee->userpath(1).'/edit')->assertRedirect('/login');

        $this->get('/{company}/employees')->assertRedirect('/login');

        $this->get($employee->userpath(1))->assertRedirect('/login');

    }

    public function signIn_user_with_no_company_cannot_manage_employees()
    {
        $this->signIn();

        $this->get('/{company}/employees/create')->assertRedirect('/login');

        $employee = factory(Employee::class)->create();

        $this->post('/{company}/employees', $employee->toArray())->assertRedirect('/login');

        $this->patch($employee->userpath(1))->assertRedirect('/login');

        $this->delete($employee->userpath(1))->assertRedirect('/login');

        $this->get($employee->userpath(1).'/edit')->assertRedirect('/login');

        $this->get('/{company}/employees')->assertRedirect('/login');

        $this->get($employee->userpath(1))->assertRedirect('/login');

    }


    public function signedInUser_can_only_access_their_company_employees()
    {
        $this->withoutExceptionHandling();

        $this->signInUser();

        $response = $this->get('/1/employees');

        $response->assertOk();

        $response = $this->get('/2/employees');

        $response->assertRedirect('/login');

    }


    public function an_employee_can_be_created_by_signedInManager()
    {

//        $this->signInUser();
//
//        $this->get('/companies/1/employees/create')->assertStatus(403);

        $this->signInManager();

        $response = $this->post('/1/employees', $attributes = factory(Employee::class)->raw([
            'company_id' => 1,
        ]));

        $employee = Employee::all();

        $this->assertCount(1, $employee);

        $employee = Employee::where('id', 1)->first();

        $response->assertRedirect('/1/employees');

    }


    public function a_employee_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->signInManager();

        $response = $this->post('/1/employees', $attributes = factory(Employee::class)->raw([
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


    public function an_employee_can_be_destroyed_by_signInAdmin()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $employee = factory(Employee::class)->create();

        $response = $this->delete($employee->userpath(1));

        $this->assertCount(0, Employee::all());

        $response->assertRedirect('/1/employees');

    }

    /** @test */
    public function signedInSuperAdmin_can_only_access_all_companies_employees()
    {
        //$this->withoutExceptionHandling();


        $this->signInSuperAdmin();

        $this->get('/1/employees')->assertOk();




    }

    /** @test */
    public function employee_has_composite_unique_number_when_edited()
    {
        $this->signInAdmin();

        factory(Employee::class)->create(['company_id' => 2, 'number' => 1]);

        factory(Employee::class)->create(['company_id' => 1, 'number' => 1]);

        $this->post('/1/employees', $attributes = factory(Employee::class)->raw([
            'company_id' => 1,
            'number' => 1,
        ]))->assertSessionHasErrors('number');

        $this->post('/1/employees', $attributes = factory(Employee::class)->raw([
            'company_id' => 1,
            'number' => 2,
        ]))->assertSessionHasNoErrors();

        $this->post('/2/employees', $attributes = factory(Employee::class)->raw([
            'company_id' => 2,
            'number' => 2,
        ]))->assertSessionHasNoErrors();

      }

      /** @test */
    public function employee_has_composite_unique_number_when_created()
    {
        $this->signInAdmin();

        $employee = factory(Employee::class)->create(['company_id' => 2, 'number' => 1]);

        $this->patch($employee->userpath(2), $attributes = [
            'number'=> 1,
        ])->assertSessionHasNoErrors();

        factory(Employee::class)->create(['company_id' => 1, 'number' => 2]);

        $employee = factory(Employee::class)->create(['company_id' => 1, 'number' => 1]);

        $this->patch($employee->userpath(1), $attributes = [
            'number'=> 2,
        ])->assertSessionHasErrors('number');

    }








}
