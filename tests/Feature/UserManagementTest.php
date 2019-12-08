<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Role;


class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_be_created()
    {
        $response = $this->post('/admin/users', $attributes = factory(User::class)->raw());

        $user = User::all();
        $response->assertOk();
        $this->assertCount(1, $user);
        //$this->assertEquals(Role::first()->id, User::first()->role_id);

    }

    /** @test */
    public function a_user_can_be_updated()
    {

        $this->post('/admin/users', [

            'name'=>'User Name',
            'surname'=>'User Surname',
            'email' => 'test@test.com',
            'password'=> 'password',
            'role_id' => 1,
            'company_id'=> 1,
        ]);

        $user = User::first();

        $response = $this->patch('/admin/users/'. $user->id,[
            'name'=> 'New Name',
            'surname'=> 'New Surname',
            'email' => 'new@test.com',
            'password'=> 'new pass',
            'role_id' => 2,
            'company_id'=> 2,
            ]);

        $this->assertEquals('New Name', User::first()->name);
        $this->assertEquals('New Surname', User::first()->surname);
        $this->assertEquals(2, User::first()->role_id);
        $response->assertRedirect($user->fresh()->path());
    }

    /** @test */
    public function a_user_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/admin/users', $attributes = factory(User::class)->raw());

        $user = User::first();

        $this->assertCount(1, User::all());

        $response = $this->delete($user->path());

        $this->assertCount(0, User::all());

        $response->assertRedirect('/admin/users');

    }
}
