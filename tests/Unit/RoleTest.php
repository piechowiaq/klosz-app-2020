<?php

namespace Tests\Unit;

use App\Role;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_role_belongs_to_many_users()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();

        $role->users()->sync($user);

        $this->assertDatabaseHas('role_user', [
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    function role_has_a_path()
    {
        $role = factory(Role::class)->create();

        $this->assertEquals("/admin/roles/{$role->id}", $role->path());
    }
}
