<?php

namespace Tests\Unit;

use App\Department;
use App\Employee;
use App\Position;
use App\Training;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_position_belongs_to_many_departments()
    {
        $position = factory(Position::class)->create();

        $department = factory(Department::class)->create();

        $position->departments()->sync($department);

        $this->assertDatabaseHas('department_position', [
            'department_id' => $department->id,
            'position_id' => $position->id
        ]);
    }

    /** @test */
    public function an_position_belongs_to_many_employees()
    {
        $employee = factory(Employee::class)->create();

        $position = factory(Position::class)->create();

        $position->employees()->sync($employee);

        $this->assertDatabaseHas('employee_position', [
            'position_id' => $position->id,
            'employee_id' => $employee->id
        ]);
    }

    /** @test */
    public function a_position_belongs_to_many_trainings()
    {
        $position = factory(Position::class)->create();

        $training = factory(Training::class)->create();

        $position->trainings()->sync($training);

        $this->assertDatabaseHas('position_training', [
            'training_id' => $training->id,
            'position_id' => $position->id
        ]);
    }

    /** @test */
    function employee_has_a_path()
    {
        $employee = factory(Employee::class)->create();

        $this->assertEquals("/admin/employees/{$employee->id}", $employee->path());
    }
}
