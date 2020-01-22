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
        $this->withoutExceptionHandling();

//       $this->signInSuperAdmin();

        $this->post('/admin/users', $attributes = factory(User::class)->raw());

       $this->assertCount(1, User::all());

//        $user = User::where('id', 1)->first();
//
//        $response->assertRedirect($user->path());
    }


    public function a_user_can_be_updated()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/users', $attributes = factory(User::class)->raw());

        $user = User::where('id', 2)->first();

        $response = $this->patch($user->path(), $attributes=[
                'name' => 'New Name'

            ]);

        $this->assertEquals('New Name', User::where('id', 2)->first()->name);

        $this->assertDatabaseHas('Users', $attributes);

        $response->assertRedirect($user->path());
    }

    public function a_role_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->signInSuperAdmin();

        $this->post('/admin/roles', $attributes = factory(Role::class)->raw());

        $role = Role::where('id', 2)->first();

        $response = $this->patch('/admin/roles/'. $role->id , $attributes = [
            'name' => 'New Name',
            'description' => 'New Description'
        ]);

        $this->assertEquals('New Name', Role::where('id', 2)->first()->name);

        $this->assertDatabaseHas('Roles', $attributes);

        $response->assertRedirect($role->path());
    }






    public function a_user_can_be_deleted()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/roles', $attributes = factory(User::class)->raw());

        $this->assertCount(2, User::all());

        $user = User::where('id', 2)->first();

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


    public function a_role_id_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/users', array_merge($attributes = factory(User::class)->raw(), ['role_id' => '']));

        $response->assertSessionHasErrors('role_id');
    }

 
    public function a_company_id_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/users', array_merge($attributes = factory(User::class)->raw(), ['company_id' => '']));

        $response->assertSessionHasErrors('company_id');
    }

    /** @test */
    public function updated_user_updates_intermediate_tables()
    {
        $users = factory(User::class,2)->create();
        $roles = factory(Role::class,2)->create();
        $companies =factory(Company::class,2)->create();

        $user = User::where('id', '1')->first();
        $role = Role::where('id', '1')->first();
        $company = Company::where('id', '1')->first();


        $user->roles()->attach($role);
        $user->companies()->attach($company);

        $this->assertDatabaseHas('role_user', [
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);
        $this->assertDatabaseHas('company_user', [
            'company_id' => $company->id,
            'user_id' => $user->id
        ]);

        $role = Role::where('id', '2')->first();

        $company = Company::where('id', '2')->first();

        $user->roles()->sync(['role_id'=>$role->id]);

        $user->companies()->sync(['company_id'=>$company->id]);

        $this->assertDatabaseHas('role_user', [
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('company_user', [
            'company_id' => $company->id,
            'user_id' => $user->id
        ]);
    }


}
