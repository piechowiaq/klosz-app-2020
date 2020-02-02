<?php

namespace Tests\Feature;

use App\Department;
use App\Position;
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

        $this->get('/admin/trainings')->assertRedirect('/login');

        $this->get($training->path())->assertRedirect('/login');

    }

    /** @test */
    public function only_authorized_user_can_manage_trainings()
    {
        $training = factory(Training::class)->create();

        $this->signIn();

        $this->get($training->path().'/edit')->assertStatus(403);

        $this->get('/admin/trainings/create')->assertStatus(403);

        $this->get('/admin/trainings')->assertStatus(403);

        $this->get('/admin/trainings/'.$training->id)->assertStatus(403);

        $this->post('/admin/trainings', $attributes = factory(Training::class)->raw())->assertStatus(403);

        $this->patch($training->path(), $attributes = [
            'name'=> 'New Name',
        ])->assertStatus(403);

        $this->delete($training->path())->assertStatus(403);


    }

    /** @test */
    public function a_training_can_be_created()
    {
        $position = factory(Position::class)->create();

        $this->signIn();

        $this->get('/admin/trainings/create')->assertStatus(403);

        $this->signInSuperAdmin();

        $response = $this->post('/admin/trainings', $attributes = factory(Training::class)->make()->positions()->attach($position));

        $training = Training::first();

        $this->assertDatabaseHas('position_training', [
            'position_id' => $position->id,
            'training_id' => $training->id
        ]);

        $training = Training::all();

        $this->assertCount(1, $training);

        $response->assertRedirect($training->path());

//        $this->signIn();
//
//        $this->get('/admin/trainings/create')->assertStatus(403);
//
//        $this->signInSuperAdmin();
//
//        $response = $this->post('/admin/trainings', $attributes = factory(Training::class)->raw());
//
//        $training = Training::all();
//
//        $this->assertCount(1, $training);
//
//        $training = Training::where('id', 1)->first();
//
//        $response->assertRedirect($training->path());

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
