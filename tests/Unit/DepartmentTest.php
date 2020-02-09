<?php

namespace Tests\Unit;

use App\Company;
use App\Department;
use App\Employee;
use App\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_department_belongs_to_many_employees()
    {
        $department = factory(Department::class)->create();

        $employee = factory(Employee::class)->create();

        $department->employees()->sync($employee);

        $this->assertDatabaseHas('department_employee', [
            'department_id' => $department->id,
            'employee_id' => $employee->id
        ]);
    }

    /** @test */
    public function a_department_has_many_positions()
    {
        $department = factory(Department::class)->create();

        $position = factory(Position::class)->create(['department_id'=>$department->id]);

        $this->assertTrue($department->positions->contains($position));

    }

    /** @test */
    function department_has_a_path()
    {
        $department = factory(Department::class)->create();

        $this->assertEquals("/admin/departments/{$department->id}", $department->path());
    }

    /** @test */
    public function a_department_belongs_to_many_companies()
    {
        $department = factory(Department::class)->create();

        $company = factory(Company::class)->create();

        $department->companies()->sync($company);

        $this->assertDatabaseHas('company_department', [
            'company_id' => $company->id,
            'department_id' => $department->id
        ]);
    }
}
