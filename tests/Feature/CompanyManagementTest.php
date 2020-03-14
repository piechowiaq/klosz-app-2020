<?php

namespace Tests\Feature;

use App\Company;
use App\Department;
use App\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_company_can_be_created()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/companies', $attributes = factory(Company::class)->raw());

        $company = Company::all();

        $this->assertCount(1, $company);

    }

    /** @test */
    public function a_company_can_be_updated()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/companies', $attributes = factory(Company::class)->raw());

        $company = Company::first();

        $response = $this->patch($company->path(), $attributes = [
            'name'=> 'New Name',
        ]);

        $this->get($company->path().'/edit')->assertOk();

        $this->assertDatabaseHas('companies', $attributes);

        $response->assertRedirect($company->fresh()->path());
    }

    /** @test */
    public function a_company_can_be_deleted()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/companies', $attributes = factory(Company::class)->raw());

        $company = Company::first();

        $this->assertCount(1, Company::all());

        $response = $this->delete($company->path());

        $this->assertCount(0, Company::all());

        $response->assertRedirect('/admin/companies');

    }

    /** @test */
    public function a_company_name_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/companies', array_merge($attributes = factory(Company::class)->raw(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_company_is_attached_to_positions_departments_when_created()
    {
        $department = factory(Department::class)->create();

        $companies = factory(Company::class, 3)
            ->create()
            ->each(function($company) use ($department) {
                $company->positions()->save(factory(Position::class)->make(['department_id' => $department->id]));
            });

        $this->assertCount(3, $companies);
        $this->assertCount(3, Position::all());
    }

}
