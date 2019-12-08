<?php

namespace Tests\Unit;

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

//    /** @test */
//    function role_has_a_path()
//    {
//        $role = factory(Role::class)->create();
//
//        $this->assertEquals("/admin/roles/{$role->id}", $role->path());
//    }
}
