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
//
//        $this->patch($employee->path())->assertRedirect('/login');
//
//        $this->delete($employee->path())->assertRedirect('/login');
//
//        $this->get($employee->path().'/edit')->assertRedirect('/login');
//
//        $this->get('/admin/employees')->assertRedirect('/login');
//
//        $this->get($employee->path())->assertRedirect('/login');

    }

    /** @test */
    public function a_employee_can_be_created()
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
}
