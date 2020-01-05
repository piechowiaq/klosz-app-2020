<?php

namespace Tests\Feature;

use App\Company;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable;

class RoleManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_role_can_be_created()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/roles', $attributes = factory(Role::class)->raw());

        $role = Role::all();

        $response->assertOk();

        $this->assertCount(2, $role);

    }

    /** @test */
    public function a_role_can_be_updated()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/roles', $attributes = factory(Role::class)->raw());

        $role = Role::where('id', '2')->first();

        $response = $this->patch('/admin/roles/'. $role->id, $attributes = [
            'name'=> 'New Role',
        ]);

        $this->get($role->path().'/edit')->assertOk();

        $this->assertDatabaseHas('roles', $attributes);

        $response->assertRedirect($role->fresh()->path());
    }

    /** @test */
    public function a_role_can_be_deleted()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/roles', $attributes = factory(Role::class)->raw());

        $role = Role::first();

        $this->assertCount(2, Role::all());

        $response = $this->delete($role->path());

        $this->assertCount(1, Role::all());

        $response->assertRedirect('/admin/roles');

    }

    /** @test */
    public function a_role_name_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/roles', array_merge($attributes = factory(Role::class)->raw(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_role_description_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/roles', array_merge($attributes = factory(Role::class)->raw(), ['description' => '']));

        $response->assertSessionHasErrors('description');
    }

}
