<?php

namespace Tests\Feature;

use App\Certificate;
use App\Training;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCertificateManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_certificates()
    {
        //$this->withoutExceptionHandling();

        $this->get('/{company}/certificates/create')->assertRedirect('/login');

        $certificate = factory(Certificate::class)->create();

        $this->post('/{company}/certificates', $certificate->toArray())->assertRedirect('/login');

        $this->patch($certificate->userpath(1))->assertRedirect('/login');

        $this->delete($certificate->userpath(1))->assertStatus(405);

        $this->get($certificate->userpath(1).'/edit')->assertRedirect('/login');

        $this->get('/{company}/certificates')->assertRedirect('/login');

        $this->get($certificate->userpath(1))->assertRedirect('/login');
    }

    /** @test */
    public function certificates_cannot_be_managed_by_user_with_no_company()
    {
        $this->signIn();

        $this->get('/{company}/certificates/create')->assertRedirect('/login');

        $certificate = factory(Certificate::class)->create();

        $this->post('/{company}/certificates', $certificate->toArray())->assertRedirect('/login');

        $this->patch($certificate->userpath(1))->assertRedirect('/login');

        $this->delete($certificate->userpath(1))->assertStatus(405);;

        $this->get($certificate->userpath(1).'/edit')->assertRedirect('/login');

        $this->get('/{company}/certificates')->assertRedirect('/login');

        $this->get($certificate->userpath(1))->assertRedirect('/login');

    }

    /** @test */
    public function signedInUser_can_only_access_their_company_certificates()
    {
        $this->signInUser();

        $response = $this->get('/1/certificates');

        $response->assertOk();

        $this->get('/1/certificates/create')->assertStatus(403);

        $response = $this->get('/2/certificates');

        $response->assertRedirect('/login');

    }

    /** @test */
    public function a_certificate_can_be_created_by_signedInManager()
    {
        $this->withoutExceptionHandling();

        $this->signInManager();

        $response = $this->post('/1/certificates', $attributes = factory(Certificate::class)->raw([
            'company_id' => 1,
        ]));

        $certificate = Certificate::all();

        $this->assertCount(1,  $certificate);

        $certificate = Certificate::where('id', 1)->first();

        $response->assertRedirect($certificate->userpath(1));

    }

    /** @test */
    public function a_certificate_can_not_be_created_by_signedInUser()
    {
       $this->signInUser();

        $response = $this->post('/1/certificates', $attributes = factory(Certificate::class)->raw([
            'company_id' => 1,
        ]));

        $certificate = Certificate::all();

        $this->assertCount(0,  $certificate);

        $response->assertStatus(403);

    }


    /** @test */
    public function a_certificate_can_be_updated_by_signedInManager()
    {
        $this->withoutExceptionHandling();

        $this->signInManager();

        $response = $this->post('/1/certificates', $attributes = factory(Certificate::class)->raw([
            'company_id' => 1,
        ]));

        $certificate = Certificate::first();

        $training = factory(Training::class)->create();

        $response = $this->patch($certificate->userpath(1), $attributes = [
            'training_id'=> 2,
        ]);

        $this->get($certificate->userpath(1).'/edit')->assertOk();

        $this->assertDatabaseHas('certificates', $attributes);

        $response->assertRedirect($certificate->fresh()->userpath(1));
    }

    /** @test */
    public function a_certificate_can_not_be_updated_by_signedInUser()
    {
        $this->signInUser();

        $certificate = factory(Certificate::class)->create(['company_id'=> 1,]);

        $training = factory(Training::class)->create();

        $response = $this->patch($certificate->userpath(1), $attributes = [
            'training_id'=> 2,
        ]);

        $this->get($certificate->userpath(1).'/edit')->assertStatus(403);

        $this->assertDatabaseMissing('certificates', $attributes);


        $response->assertStatus(403);

    }



}
