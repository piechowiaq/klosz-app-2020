<?php

namespace Tests\Feature;

use App\Certificate;
use App\Training;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CertificateManagementTest extends TestCase
{
    use RefreshDatabase;

    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

//    /** @test */
//    public function guests_cannot_manage_certificates()
//    {
//
//
//
//        $this->get('/admin/certificates/create')->assertRedirect('login');
//
//        $certificate = factory(Certificate::class)->create();
//
//        $this->post('/admin/certificates', $certificate->toArray())->assertRedirect('login');
//
//        $this->patch($certificate->path())->assertRedirect('/login');
//
//        $this->delete($certificate->path())->assertRedirect('/login');
//
//        $this->get($certificate->path().'/edit')->assertRedirect('/login');
//
//        $this->get('/admin/certificates')->assertRedirect('/login');
//
//        $this->get($certificate->path())->assertRedirect('/login');
//
//    }
//    /** @test */
//    public function certificates_cannot_be_managed_by_non_super_admin()
//    {
//        $this->signIn();
//
//        $this->get('/admin/certificates/create')->assertStatus(403);
//
//        $certificate = factory(Certificate::class)->create();
//
//        $this->post('/admin/certificates', $certificate->toArray())->assertStatus(403);
//
//        $this->patch($certificate->path())->assertStatus(403);
//
//        $this->delete($certificate->path())->assertStatus(403);
//
//        $this->get($certificate->path().'/edit')->assertStatus(403);
//
//        $this->get('/admin/certificates')->assertStatus(403);
//
//        $this->get($certificate->path())->assertStatus(403);
//
//    }
//
//
//    /** @test */
//    public function a_certificate_can_be_created()
//    {
//        $this->signIn();
//
//        $this->post('/admin/certificates', $attributes = factory(Certificate::class)->raw());
//
//        $certificate = Certificate::all();
//
//        $this->assertCount(0, $certificate);
//
//        $this->signInSuperAdmin();
//
//        $this->get('/admin/certificates/create')->assertOk();
//
//        $response = $this->post('/admin/certificates', $attributes = factory(Certificate::class)->raw());
//
//        $certificate = Certificate::all();
//
//        $this->assertCount(1, $certificate);
//
//        $certificate = Certificate::where('id', 1)->first();
//
//        $response->assertRedirect($certificate->path());
//
//    }
//
//
//
//    /** @test */
//    public function a_certificate_cannot_be_updated_by_no_super_admin()
//    {
//        $this->signIn();
//
//        $certificate = factory(Certificate::class)->create();
//
//        $this->patch( $certificate->path())->assertStatus(403);
//    }
//
//
//    /** @test */
//    public function a_certificate_can_be_updated()
//    {
//       $this->withoutExceptionHandling();
//
//        $training = factory(Training::class)->create();
//
//        $this->signInSuperAdmin();
//
//        $this->get('/admin/certificates/create')->assertOk();
//
//        $response = $this->post('/admin/certificates', $attributes = factory(Certificate::class)->raw());
//
//        $certificate = Certificate::first();
//
//        $response = $this->patch($certificate->path(), $attributes = [
//            'training_id'=> 2,
//        ]);
//
//        $this->get($certificate->path().'/edit')->assertOk();
//
//        $this->assertDatabaseHas('certificates', $attributes);
//
//        $response->assertRedirect($certificate->fresh()->path());
//    }
//
//    /** @test */
//    public function a_cerificate_cannot_be_deleted_by_no_super_admin()
//    {
//        $certificate = factory(Certificate::class)->create();
//
//        $this->signIn();
//
//        $response = $this->delete($certificate->path());
//
//        $this->assertCount(1, Certificate::all());
//    }
//
//
//    /** @test */
//    public function a_certificate_can_be_deleted()
//    {
//        $this->signInSuperAdmin();
//
//        $this->post('/admin/certificates', $attributes = factory(Certificate::class)->raw());
//
//        $certificate = Certificate::first();
//
//        $this->assertCount(1, Certificate::all());
//
//        $response = $this->delete($certificate->path());
//
//        $this->assertCount(0, Certificate::all());
//
//        $response->assertRedirect('/admin/certificates');
//
//    }
//
//    /** @test */
//    public function a_certificate_name_is_required()
//    {
//
//
//        $this->signInSuperAdmin();
//
//        $certificate = factory(Certificate::class)->make([
//            'training_id' => null,
//         ]);
//
//        $response = $this->post('/admin/certificates', $certificate->toArray())->assertSessionHasErrors('training_id');
//
//        $this->assertEquals(0, Certificate::count());
//
//
//
////        $response = $this->post('/admin/certificates', array_merge($attributes = factory(Certificate::class)->raw(), ['training_id' => '']));
////
////        $response->assertSessionHasErrors('training_id');
//    }

}
