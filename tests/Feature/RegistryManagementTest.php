<?php

namespace Tests\Feature;

use App\Registry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistryManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_registries()
    {
        $this->get('/admin/registries')->assertRedirect('/login');

        $this->get('/admin/registries/create')->assertRedirect('login');

        $registry = factory(Registry::class)->create();

        $this->post('/admin/registries', factory(Registry::class)->raw())->assertRedirect('login');

        $this->get($registry->path())->assertRedirect('/login');

        $this->get($registry->path().'/edit')->assertRedirect('/login');

        $this->patch($registry->path())->assertRedirect('/login');

        $this->delete($registry->path())->assertRedirect('/login');

    }

    /** @test */
    public function authorised_users_cannot_manage_registries()
    {
        $this->signInUser();

        $this->get('/admin/registries')->assertStatus(403);

        $this->get('/admin/registries/create')->assertStatus(403);

        $registry = factory(Registry::class)->create();

        $this->post('/admin/registries', factory(Registry::class)->raw())->assertStatus(403);

        $this->get($registry->path())->assertStatus(403);

        $this->get($registry->path().'/edit')->assertStatus(403);

        $this->patch($registry->path())->assertStatus(403);

        $this->delete($registry->path())->assertStatus(403);
    }

    /** @test */
    public function only_SuperAdmin_can_get_registries_routes()
    {
        $this->signInSuperAdmin();

        $this->get('/admin/registries')->assertOk();

        $this->get('/admin/registries/create')->assertOk();

        $registry = factory(Registry::class)->create();

        $this->get($registry->path())->assertOk();

        $this->get($registry->path().'/edit')->assertOk();

    }

    /** @test */
    public function a_registry_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->signInSuperAdmin();

        $response = $this->post('/admin/registries', factory(Registry::class)->raw());

        $this->assertCount(1, Registry::all());

        $registry = Registry::first();

        $response->assertRedirect($registry->path());
    }

    /** @test */
    public function a_registry_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $registry = factory(Registry::class)->create();

        $this->signInSuperAdmin();

        $response = $this->patch($registry->path(), $attributes = ['name' => 'New Name']);

        $this->assertDatabaseHas('registries', $attributes);

        $response->assertRedirect($registry->fresh()->path());
    }

    /** @test */
    public function a_registry_can_be_deleted()
    {
        $registry = factory(Registry::class)->create();

        $this->signInSuperAdmin();

        $response = $this->delete($registry->path());

        $this->assertCount(0, Registry::all());

        $response->assertRedirect('/admin/registries');

    }

    /** @test */
    public function a_registry_requires_a_name()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/registries', factory(Registry::class)->raw(['name' => '']))->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_registry_requires_a_description()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/registries', factory(Registry::class)->raw(['description' => '']))->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_registry_requires_a_valid_for()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/registries', factory(Registry::class)->raw(['valid_for' => '']))->assertSessionHasErrors('valid_for');
    }
}
