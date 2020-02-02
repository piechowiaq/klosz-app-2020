<?php

namespace Tests\Feature;

use App\Training;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrainingManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_trainings()
    {

        $this->get('/admin/trainings/create')->assertRedirect('login');

        $training = factory(Training::class)->create();

        $this->post('/admin/trainings', $training->toArray())->assertRedirect('login');

        $this->patch($training->path())->assertRedirect('/login');

        $this->delete($training->path())->assertRedirect('/login');

        $this->get($training->path().'/edit')->assertRedirect('/login');

    }

    /** @test */
    public function a_training_can_be_created()
    {
        $this->signIn();

        $this->get('/admin/trainings/create')->assertStatus(403);

        $this->signInSuperAdmin();

        $response = $this->post('/admin/trainings', $attributes = factory(Training::class)->raw());

        $training = Training::all();

        $this->assertCount(1, $training);

        $training = Training::where('id', 1)->first();

        $response->assertRedirect($training->path());

    }

    /** @test */
    public function a_training_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->signInSuperAdmin();

        $this->post('/admin/trainings', $attributes = factory(Training::class)->raw());

        $training = Training::first();

        $response = $this->patch($training->path(), $attributes = [
            'name'=> 'New Name',
        ]);

        $this->get($training->path().'/edit')->assertOk();

        $this->assertDatabaseHas('trainings', $attributes);

        $response->assertRedirect($training->fresh()->path());
    }

    /** @test */
    public function a_training_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->signInSuperAdmin();

        $this->post('/admin/trainings', $attributes = factory(Training::class)->raw());

        $training = Training::first();

        $this->assertCount(1, Training::all());

        $response = $this->delete($training->path());

        $this->assertCount(0, Training::all());

        $response->assertRedirect('/admin/trainings');

    }

    /** @test */
    public function a_training_name_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/trainings', array_merge($attributes = factory(Training::class)->raw(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }
}
