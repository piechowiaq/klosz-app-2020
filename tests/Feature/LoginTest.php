<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Role;
use App\User;



class LoginTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /** @test */

    public function a_user_belongs_to_a_role()
    {

        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();


        $this->assertInstanceOf(Role::class, $user->role);
        $this->assertCount(1, Role::all());
        $this->assertCount(1, User::all());

    }
}



