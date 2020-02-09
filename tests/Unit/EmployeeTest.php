<?php

namespace Tests\Unit;

use App\Department;
use App\Employee;
use App\Position;
use App\Training;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function an_employee_belongs_to_many_departments()
    {
        $employee = factory(Employee::class)->create();

        $department = factory(Department::class)->create();

        $employee->departments()->sync($department);

        $this->assertDatabaseHas('department_employee', [
            'department_id' => $department->id,
            'employee_id' => $employee->id
        ]);
    }

    /** @test */
    public function an_employee_belongs_to_many_positions()
    {
        $employee = factory(Employee::class)->create();

        $position = factory(Position::class)->create();

        $employee->positions()->sync($position);

        $this->assertDatabaseHas('employee_position', [
            'position_id' => $position->id,
            'employee_id' => $employee->id
        ]);
    }

    /** @test */
    public function an_employee_belongs_to_many_trainings()
    {
        $employee = factory(Employee::class)->create();

        $training = factory(Training::class)->create();

        $employee->trainings()->sync($training);

        $this->assertDatabaseHas('employee_training', [
            'training_id' => $training->id,
            'employee_id' => $employee->id
        ]);
    }

    /** @test */
    function employee_has_a_path()
    {
        $employee = factory(Employee::class)->create();

        $this->assertEquals("/admin/employees/{$employee->id}", $employee->path());
    }

    /** @test */
    public function a_user_getFullNameAttribute_works()
    {
        $employee = factory(Employee::class)->create();

        $this->assertEquals($employee->name.' '.$employee->surname,  $employee->getFullNameAttribute());

    }
}
