<?php

namespace Tests\Feature;

use App\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartmentManagementTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function guests_cannot_manage_departments()
    {
       $this->get('/admin/departments/create')->assertRedirect('login');

        $user = factory(Department::class)->create();

        $this->post('/admin/departments', $user->toArray())->assertRedirect('login');

        $this->patch($user->path())->assertRedirect('/login');

        $this->delete($user->path())->assertRedirect('/login');

        $this->get($user->path().'/edit')->assertRedirect('/login');

    }

    /** @test */
    public function a_department_can_be_created()
    {
        $this->signIn();

        $this->get('/admin/departments/create')->assertStatus(403);

        $this->signInSuperAdmin();

        $response = $this->post('/admin/departments', $attributes = factory(Department::class)->raw());

        $department = Department::all();

        $this->assertCount(1, $department);

        $department = Department::where('id', 1)->first();

        $response->assertRedirect($department->path());

    }


    /** @test */
    public function a_department_can_be_updated()
    {
        $this->signInSuperAdmin();

        $this->post('/admin/departments', $attributes = factory(Department::class)->raw());

        $department = Department::first();

        $response = $this->patch($department->path(), $attributes = [
            'name'=> 'New Name',
        ]);

        $this->get($department->path().'/edit')->assertOk();

        $this->assertDatabaseHas('departments', $attributes);

        $response->assertRedirect($department->fresh()->path());
    }

    /** @test */
    public function a_department_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $this->signInSuperAdmin();

        $this->post('/admin/departments', $attributes = factory(Department::class)->raw());

        $department = Department::first();

        $this->assertCount(1, Department::all());

        $response = $this->delete($department->path());

        $this->assertCount(0, Department::all());

        $response->assertRedirect('/admin/departments');

    }

    /** @test */
    public function a_department_name_is_required()
    {
        $this->signInSuperAdmin();

        $response = $this->post('/admin/departments', array_merge($attributes = factory(Department::class)->raw(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }
}
