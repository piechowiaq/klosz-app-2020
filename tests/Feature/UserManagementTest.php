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
        $this->withoutExceptionHandling();

        $response = $this->post('/admin/users', [

            'name'=>'User Name',
            'surname'=>'User Surname',
            'email' => 'test@test.com',
            'password'=> 'password',
            'role_id' => 1,
            'company_id'=> 1,
        ]);

        $user = User::all();
        $response->assertOk();
        $this->assertCount(1, $user);
        //$this->assertEquals(Role::first()->id, User::first()->role_id);

    }
}
