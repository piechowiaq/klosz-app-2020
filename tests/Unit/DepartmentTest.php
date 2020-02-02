<?php

namespace Tests\Unit;

use App\Department;
use App\Employee;
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
    function department_has_a_path()
    {
        $department = factory(Department::class)->create();

        $this->assertEquals("/admin/departments/{$department->id}", $department->path());
    }
}
