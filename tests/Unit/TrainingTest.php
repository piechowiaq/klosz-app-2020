<?php

namespace Tests\Unit;

use App\Department;
use App\Employee;
use App\Position;
use App\Training;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_training_belongs_to_many_departments()
    {
        $training = factory(Training::class)->create();

        $department = factory(Department::class)->create();

        $training->departments()->sync($department);

        $this->assertDatabaseHas('department_training', [
            'department_id' => $department->id,
            'training_id' => $training->id
        ]);
    }

    /** @test */
    public function a_training_belongs_to_many_employees()
    {
        $employee = factory(Employee::class)->create();

        $training = factory(Training::class)->create();

        $training->employees()->sync($employee);

        $this->assertDatabaseHas('employee_training', [
            'training_id' => $training->id,
            'employee_id' => $employee->id
        ]);
    }

    /** @test */
    public function a_training_belongs_to_many_positions()
    {
        $training = factory(Training::class)->create();

        $this->assertDatabaseHas('position_training', [
            'training_id' => $training->id,
            'position_id' => $training->positions->first()->id
        ]);
    }

    /** @test */
    function employee_has_a_path()
    {
        $employee = factory(Employee::class)->create();

        $this->assertEquals("/admin/employees/{$employee->id}", $employee->path());
    }
}
