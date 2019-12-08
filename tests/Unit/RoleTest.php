<?php

namespace Tests\Unit;

use App\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_role_has_many_users()
    {
        $role = factory('App\Role')->create();

        $this->assertInstanceOf(Collection::class, $role->users);
    }

    /** @test */
    function role_has_a_path()
    {
        $role = factory(Role::class)->create();

        $this->assertEquals("/admin/roles/{$role->id}", $role->path());
    }
}
