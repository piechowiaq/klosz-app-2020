<?php

namespace Tests\Feature;

use App\Company;
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

        $response = $this->post('/admin/companies', $attributes = factory(Company::class)->raw());

        $company = Company::all();

        $response->assertOk();

        $this->assertCount(1, $company);

    }

    /** @test */
    public function a_company_can_be_updated()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/companies', $attributes = factory(Company::class)->raw());

        $company = Company::first();

        $response = $this->patch('/admin/companies/'. $company->id, $attributes = [
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

}
