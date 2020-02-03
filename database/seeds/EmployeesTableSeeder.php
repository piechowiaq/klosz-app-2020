<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Employee::class, 10)->create()->each(function ($employee) {

            $employee->departments()->save(factory(App\Department::class)->make());
            $employee->positions()->save(factory(App\Position::class)->make());
            $employee->trainings()->save(factory(App\Training::class)->make());

        });

        factory(App\Training::class, 10)->create()->each(function ($training) {

            $training->departments()->save(factory(App\Department::class)->make());
            $training->positions()->save(factory(App\Position::class)->make());

        });

        factory(App\Department::class, 10)->create()->each(function ($department) {

            $department->positions()->save(factory(App\Position::class)->make());

        });
    }
}
