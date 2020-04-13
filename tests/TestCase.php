<?php

namespace Tests;

use App\Company;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: factory(User::class)->create();

//        $company = factory(Company::class)->create();
//
//        $user->companies()->save($company);

        $this->actingAs($user);

        return $user;
    }

    protected function signInSuperAdmin($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        $company = factory(Company::class)->create();

        $role = factory(Role::class)->create([
                'name' => 'SuperAdmin'
            ]);

        $user->roles()->save($role);

        $user->companies()->attach($company);

        $this->actingAs($user);

        return $user;
    }

    protected function signInUser($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        $company = factory(Company::class)->create();

        $role = factory(Role::class)->create([
            'name' => 'User'
        ]);

        $user->roles()->save($role);

        $user->companies()->save($company);

        $this->actingAs($user);

        return $user;
    }

    protected function signInManager($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        $company = factory(Company::class)->create();

        $role = factory(Role::class)->create([
            'name' => 'Manager'
        ]);

        $user->roles()->save($role);

        $user->companies()->save($company);

        $this->actingAs($user);

        return $user;
    }

    protected function signInAdmin($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        $company = factory(Company::class)->create();

        $role = factory(Role::class)->create([
            'name' => 'Admin'
        ]);

        $user->roles()->save($role);

        $user->companies()->save($company);

        $this->actingAs($user);

        return $user;
    }
}
