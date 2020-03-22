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

        $this->delete($certificate->userpath(1))->assertRedirect('/login');

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

        $this->delete($certificate->userpath(1))->assertRedirect('/login');

        $this->get($certificate->userpath(1).'/edit')->assertRedirect('/login');

        $this->get('/{company}/certificates')->assertRedirect('/login');

        $this->get($certificate->userpath(1))->assertRedirect('/login');

    }
}
