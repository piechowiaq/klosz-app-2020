<?php

namespace Tests\Unit;

use App\Company;
use App\Department;
use App\Position;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_company_has_many_users()
    {
        $company = factory(Company::class)->create();

        $this->assertInstanceOf(Collection::class, $company->users);
    }

    /** @test */
    public function company_has_a_path()
    {
        $company = factory(Company::class)->create();

        $this->assertEquals("/admin/companies/{$company->id}", $company->path());
    }

    /** @test */
    public function a_company_belongs_to_many_users()
    {
        $user = factory(User::class)->create();
        $company = factory(Company::class)->create();

        $company->users()->sync($user);

        $this->assertDatabaseHas('company_user', [
            'company_id' => $company->id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function a_company_belongs_to_many_positions()
    {
        $this->withoutExceptionHandling();

        $department = factory(Department::class)->create();

        $position = factory(Position::class)->create(['department_id' => $department->id]);

        $company = factory(Company::class)->create();

        $company->departments()->sync($department);

        $company->positions()->sync($position);

        $this->assertDatabaseHas('company_position', [
            'company_id' => $company->id,
            'position_id' => $position->id
        ]);

        $this->assertDatabaseHas('company_department', [
            'company_id' => $company->id,
            'department_id' => $department->id
        ]);
    }
}
