<?php

namespace Tests\Unit;

use App\Company;
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
        $company = factory('App\Company')->create();

        $this->assertInstanceOf(Collection::class, $company->users);
    }

    /** @test */
    public function company_has_a_path()
    {
        $company = factory(Company::class)->create();

        $this->assertEquals("/admin/companies/{$company->id}", $company->path());
    }

    /** @test */
    public function a_comapny_belongs_to_many_users()
    {
        $user = factory(User::class)->create();
        $company = factory(Company::class)->create();

        $company->users()->sync($user);

        $this->assertDatabaseHas('company_user', [
            'company_id' => $company->id,
            'user_id' => $user->id
        ]);
    }
}
