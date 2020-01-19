<?php

namespace Tests\Unit;



use App\Company;
use App\Role;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_has_a_path()
    {
        $user = factory(User::class)->create();

        $this->assertEquals("/admin/users/{$user->id}", $user->path());
    }

    /** @test */
    public function a_user_belongs_to_many_roles()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();

        $user->roles()->attach($role);

        $this->assertDatabaseHas('role_user', [
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function a_user_belongs_to_many_companies()
    {
        $user = factory(User::class)->create();
        $company = factory(Company::class)->create();

        $user->companies()->attach($company);

        $this->assertDatabaseHas('company_user', [
            'company_id' => $company->id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function a_user_getFullNameAttribute_works()
    {
        $user = factory(User::class)->create();

        $this->assertEquals($user->name.' '.$user->surname,  $user->getFullNameAttribute());

    }

    /** @test */
    public function a_role_user_table_withTimestamps()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();

        $user->roles()->attach($role);

        $this->assertDatabaseHas('role_user', [
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ]);

    }

    /** @test */
    public function a_company_user_table_withTimestamps()
    {
        $user = factory(User::class)->create();
        $company = factory(Company::class)->create();

        $user->companies()->attach($company);

        $this->assertDatabaseHas('company_user', [
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ]);

    }

}
