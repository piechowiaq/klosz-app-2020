<?php

namespace Tests;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        $this->actingAs($user);

        return $user;
    }

    protected function signInSuperAdmin($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        $user->roles()->save(factory(Role::class)->create([
            'name' => 'SuperAdmin'
        ]));

        $this->actingAs($user);

        return $user;
    }
}
