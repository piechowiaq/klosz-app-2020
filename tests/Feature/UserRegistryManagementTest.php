<?php

namespace Tests\Feature;

use App\Company;
use App\Registry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistryManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_registries()
    {
        $this->get('/{company}/registries')->assertRedirect('/login');

        $registry = factory(Registry::class)->create();

        $this->get($registry->userpath(1))->assertRedirect('/login');

    }

    /** @test */
    public function signIn_cannot_get_index_and_show_registries_routes_of_companies()
    {
        $this->signIn();

        $this->get('/2/registries')->assertRedirect('/login');

        $report = factory(Registry::class)->create();

        $this->get($report->userpath(2))->assertRedirect('/login');

    }

    /** @test */
    public function signInUser_cannot_get_index_and_show_registries_routes_of_companies()
    {
        $this->signInUser();

        $this->get('/2/registries')->assertRedirect('/login');

        $report = factory(Registry::class)->create();

        $this->get($report->userpath(2))->assertRedirect('/login');

    }

    /** @test */
    public function signInManager_cannot_get_index_and_show_registries_routes_of_companies()
    {
        $this->signInManager();

        $this->get('/2/registries')->assertRedirect('/login');

        $report = factory(Registry::class)->create();

        $this->get($report->userpath(2))->assertRedirect('/login');

    }

    /** @test */
    public function signInAdmin_cannot_get_index_and_show_registries_routes_of_companies()
    {
        $this->signInAdmin();

        $this->get('/2/registries')->assertRedirect('/login');

        $report = factory(Registry::class)->create();

        $this->get($report->userpath(2))->assertRedirect('/login');

    }


    public function signInSuperAdmin_can_get_index_and_show_registries_routes_of_any_company()
    {
//        $this->withoutExceptionHandling();

        $this->signInSuperAdmin();

        $this->get('/1/registries')->assertOk();

        $report = factory(Registry::class)->create();

        $this->get($report->userpath(1))->assertOk();

    }

    /** @test */
    public function signInUser_can_get_index_and_show_registries_routes_of_their_company()
    {
        $this->signInUser();

        $this->get('/1/registries')->assertOk();

        $report = factory(Registry::class)->create();

        $this->get($report->userpath(1))->assertOk();
    }

    /** @test */
    public function signInManager_can_get_index_and_show_registries_routes_of_their_company()
    {
        $this->signInManager();

        $this->get('/1/registries')->assertOk();

        $report = factory(Registry::class)->create();

        $this->get($report->userpath(1))->assertOk();
    }

    /** @test */
    public function signInAdmin_can_get_index_and_show_registries_routes_of_their_company()
    {
        $this->signInManager();

        $this->get('/1/registries')->assertOk();

        $report = factory(Registry::class)->create();

        $this->get($report->userpath(1))->assertOk();
    }
}
