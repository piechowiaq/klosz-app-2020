<?php

namespace Tests\Feature;

use App\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PositionManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_positions()
    {
        $this->get('/admin/positions/create')->assertRedirect('login');

        $position = factory(Position::class)->create();

        $this->post('/admin/positions', $position->toArray())->assertRedirect('login');

        $this->patch($position->path())->assertRedirect('/login');

        $this->delete($position->path())->assertRedirect('/login');

        $this->get($position->path().'/edit')->assertRedirect('/login');

        $this->get('/admin/positions')->assertRedirect('/login');

        $this->get($position->path())->assertRedirect('/login');

    }

    /** @test */
    public function a_position_can_be_created()
    {
        $this->signIn();

        $this->get('/admin/positions/create')->assertStatus(403);

        $this->withoutExceptionHandling();

        $this->signInSuperAdmin();

        $response = $this->post('/admin/positions', $attributes = factory(Position::class)->raw());

        $position = Position::all();

        $this->assertCount(1, $position);

        $position = Position::where('id', 1)->first();

        $response->assertRedirect($position->path());

    }

    /** @test */
    public function a_position_can_be_updated()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/positions', $attributes = factory(Position::class)->raw());

        $position = Position::first();

        $response = $this->patch($position->path(), $attributes = [
            'name'=> 'New Name',
        ]);

        $this->get($position->path().'/edit')->assertOk();

        $this->assertDatabaseHas('positions', $attributes);

        $response->assertRedirect($position->fresh()->path());
    }

    /** @test */
    public function a_position_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->signInSuperAdmin();

        $this->post('/admin/positions', $attributes = factory(Position::class)->raw());

        $position = Position::first();

        $this->assertCount(1, Position::all());

        $response = $this->delete($position->path());

        $this->assertCount(0, Position::all());

        $response->assertRedirect('/admin/positions');

    }

    /** @test */
    public function a_position_name_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/positions', array_merge($attributes = factory(Position::class)->raw(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

}
