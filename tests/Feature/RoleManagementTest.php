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


    public function a_role_can_be_created()
    {


        $this->post('/admin/roles', $attributes = factory(Role::class)->raw());

        $role = Role::all();

        $this->assertCount(2, $role);

    }

    /** @test */
    public function a_role_can_be_created_MASTER()
    {
//        $this->withoutMiddleware();

        $this->withoutExceptionHandling();

        //$this->signInSuperAdmin();

        $response = $this->post('/admin/roles', $attributes = factory(Role::class)->raw());

        $role = Role::first();

        $this->assertCount(1, Role::all());

        $response->assertRedirect($role->path());
    }




    /** @test */
    public function a_role_can_be_updated_MASTER()
    {
//        $this->withoutMiddleware();

        $this->withoutExceptionHandling();

        $this->post('/admin/roles', $attributes = factory(Role::class)->raw());

        $role = Role::first();

        $response = $this->patch($role->path(), [
            'name' => 'New Name',
            'description' => 'New Description'

        ]);

        $this->assertEquals('New Name', Role::first()->name);
        $this->assertEquals('New Description', Role::first()->description);

        $response->assertRedirect($role->path());

    }


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


    public function a_role_name_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/roles', array_merge($attributes = factory(Role::class)->raw(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }


    public function a_role_description_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/roles', array_merge($attributes = factory(Role::class)->raw(), ['description' => '']));

        $response->assertSessionHasErrors('description');
    }

}
