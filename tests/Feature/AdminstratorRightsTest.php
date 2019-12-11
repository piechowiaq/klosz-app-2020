<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

//class AdminstratorRightsTest extends TestCase
{
//    use RefreshDatabase;
//
////    /** @test */
////    public function only_user_with_superadmin_role_can_view_admin_dashboard()
////    {
////        $user = factory(User::class)
////            ->create()
////            ->each(function ($user) {
////                $user->roles()->save(factory(Role::class)->make([
////                    'name' => 'SuperAdmin',
////                ]));
////            });
////
////        $this->actingAs($user)
////            ->get('/admin')
////            ->assertOk();
////
////        //$this->get('/admin')->assertRedirect('/login');
////    }
}
