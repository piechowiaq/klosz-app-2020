<?php

namespace Tests\Feature;

use App\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Role;




class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_SuperAdmin_can_access_admin_panel()
    {

        $this->get('/admin')->assertRedirect('login');

        $this->signIn();

        $this->get('/admin')->assertStatus(403);

        $this->signInSuperAdmin();

        $this->get('/admin')->assertOk();

    }


    /** @test */
    public function guests_cannot_manage_users()
    {

        $this->get('/admin/users/create')->assertRedirect('login');

        $user = factory(User::class)->create();

        $this->post('/admin/users', $user->toArray())->assertRedirect('login');

        $this->patch($user->path())->assertRedirect('/login');

        $this->delete($user->path())->assertRedirect('/login');

        $this->get($user->path().'/edit')->assertRedirect('/login');

    }


    /** @test */
    public function a_user_can_be_created()
    {
        $this->signIn();

        $this->get('/admin/users/create')->assertStatus(403);

        $this->signInSuperAdmin();

        $this->get('/admin/users/create')->assertStatus(200);

        $response = $this->post('/admin/users', $attributes = factory(User::class)->raw());

        $user = User::all();

        $response->assertOk();

        $this->assertCount(3, $user);

        //$this->assertEquals(Role::first()->id, User::first()->role_id);

        //$this->assertEquals(Company::first()->id, User::first()->company_id);

    }

    /** @test */
    public function a_user_can_be_updated()
    {

        $this->signInSuperAdmin();

        $this->post('/admin/users', $attributes = factory(User::class)->raw());

        $user = User::first();

        $response = $this->patch('/admin/users/'. $user->id, $attributes = [
            'name'=> 'New Name',
         ]);

        $this->get($user->path().'/edit')->assertOk();

        $this->assertDatabaseHas('users', $attributes);

        $response->assertRedirect($user->fresh()->path());


    }

    /** @test */
    public function a_user_can_be_deleted()
    {

        $this->signInSuperAdmin();

        $this->post('/admin/users', $attributes = factory(User::class)->raw());

        $user = User::first();

        $this->assertCount(2, User::all());

        $response = $this->delete($user->path());

        $this->assertCount(1, User::all());

        $response->assertRedirect('/admin/users');

    }

    /** @test */
    public function a_name_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/users', array_merge($attributes = factory(User::class)->raw(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_surname_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/users', array_merge($attributes = factory(User::class)->raw(), ['surname' => '']));

        $response->assertSessionHasErrors('surname');
    }

    /** @test */
    public function an_email_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/users', array_merge($attributes = factory(User::class)->raw(), ['email' => '']));

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function a_password_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/users', array_merge($attributes = factory(User::class)->raw(), ['password' => '']));

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function a_role_id_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/users', array_merge($attributes = factory(User::class)->raw(), ['role_id' => '']));

        $response->assertSessionHasErrors('role_id');
    }

    /** @test */
    public function a_company_id_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/users', array_merge($attributes = factory(User::class)->raw(), ['company_id' => '']));

        $response->assertSessionHasErrors('company_id');
    }

}
