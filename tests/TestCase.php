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

        $company = factory(Company::class)->create();

        $user->companies()->save($company);

        $this->actingAs($user);

        return $user;
    }

    protected function signInSuperAdmin($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        $role = factory(Role::class)->create([
                'name' => 'SuperAdmin'
            ]);

        $user->roles()->save($role);

        $this->actingAs($user);

        return $user;
    }
}
