<?php

namespace Tests\Unit;



use App\Company;
use App\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_has_role()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Role::class, $user->role);
    }

    /** @test */
    public function a_user_has_company()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Company::class, $user->company);
    }

    function user_has_a_path()
    {
        $user = factory(User::class)->create();

        $this->assertEquals("/admin/users/{$user->id}", $user->path());
    }
}
