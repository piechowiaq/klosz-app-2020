<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function only_signed_user_can_access_home_page()
    {
        $this->get('/home')->assertRedirect('login');

        $this->signIn();

        $response = $this->get('/home')->assertOk();

        $response->assertViewIs('home');

//        $response->assertSee();







    }
}