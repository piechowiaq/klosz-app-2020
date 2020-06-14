<?php

namespace Tests\Feature;

use App\Certificate;
use App\Company;
use App\Training;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCertificateManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_certificates()
    {
//        $this->withoutExceptionHandling();

        $this->get('/{company}/certificates/create')->assertRedirect('/login');

        $certificate = factory(Certificate::class)->create();

        $this->post('/{company}/certificates', $certificate->toArray())->assertRedirect('/login');

        $this->patch($certificate->userpath(1, 1))->assertRedirect('/login');

        $this->delete($certificate->userpath(1, 1))->assertRedirect('/login');

        $this->get($certificate->userpath(1, 1).'/edit')->assertRedirect('/login');

        $this->get('/{company}/trainings/{training}/certificates')->assertRedirect('/login');

        $this->get($certificate->userpath(1, 1))->assertRedirect('/login');
    }

    /** @test */
    public function certificates_cannot_be_managed_by_user_with_no_company()
    {
        $this->signIn();

        $this->get('/{company}/certificates/create')->assertRedirect('/login');

        $certificate = factory(Certificate::class)->create();

        $this->post('/{company}/certificates', $certificate->toArray())->assertRedirect('/login');

        $this->patch($certificate->userpath(1, 1))->assertRedirect('/login');

        $this->delete($certificate->userpath(1, 1))->assertRedirect('/login');

        $this->get($certificate->userpath(1, 1).'/edit')->assertRedirect('/login');

        $this->get('/{company}/trainings/{training}/certificates')->assertRedirect('/login');

        $this->get($certificate->userpath(1, 1))->assertRedirect('/login');

    }

    /** @test */
    public function signedInUser_can_only_access_their_company_certificates()
    {
        $this->signInUser();

        factory(Training::class)->create();

        $this->get('/1/trainings/1/certificates')->assertOk();

        $this->get('/1/certificates/create')->assertStatus(403);

        $response = $this->get('/2/trainings/1/certificates');

        $response->assertRedirect('/login');

    }

//    /** @test */
    public function a_certificate_can_be_created_by_signedInManager()
    {
        $this->withoutExceptionHandling();

        $this->signInManager();

        Storage::fake('public');

        $response = $this->post('/1/certificates', $attributes = factory(Certificate::class)->raw([
            'company_id' => 1,
        ]));

        $this->assertCount(1,  Certificate::all());

        $certificate = Certificate::where('id', 1)->first();

        Storage::disk('public')->assertExists('certificates/'. $certificate->training_date . ' ' . $certificate->training->name . ' ' . Carbon::now()->format('His') . '.' . request('certificate_path')->getClientOriginalExtension());

        $response->assertRedirect('/1/trainings/1/certificates/1');

//        $response->assertSee('Lalka');

    }

//    /** @test */
    public function a_certificate_can_not_be_created_by_signedInUser()
    {
        $this->withoutExceptionHandling();
       $this->signInUser();

        $response = $this->post('/1/certificates', $attributes = factory(Certificate::class)->raw([
            'company_id' => 1,
        ]));

        $certificate = Certificate::all();

        $this->assertCount(0,  $certificate);

        $response->assertStatus(403);

    }


//    /** @test */
    public function a_certificate_can_be_updated_by_signedInManager()
    {
        $this->withoutExceptionHandling();

        $this->signInManager();

        $response = $this->post('/1/certificates', $attributes = factory(Certificate::class)->raw([
            'company_id' => 1,
        ]));

        $certificate = Certificate::first();

        $training = factory(Training::class)->create();

        $this->get($certificate->userpath(1, 1).'/edit')->assertOk();

        $response = $this->patch($certificate->userpath(1, 1), $attributes = [
            'training_id'=> 2,
        ]);

        $this->assertDatabaseHas('certificates', $attributes);

        $response->assertRedirect($certificate->fresh()->userpath(1, 2));
    }

//    /** @test */
    public function a_certificate_uploaded_file_can_be_updated_by_signedInManager()
    {
        $this->withoutExceptionHandling();

        $this->signInManager();

        Storage::fake('public');

        $response = $this->post('/1/certificates', $attributes = factory(Certificate::class)->raw([
            'company_id' => 1,
        ]));

        $certificate = Certificate::first();

        $training = factory(Training::class)->create();

        $response = $this->patch($certificate->userpath(1, 1), $attributes = [
            'certificate_path'=> UploadedFile::fake()->image('update.jpg'),
        ]);

        Storage::disk('public')->assertExists('certificates/'. $certificate->training_date . ' ' . $certificate->training->name . ' ' . Carbon::now()->format('His') . '.' . request('certificate_path')->getClientOriginalExtension());

    }


//    /** @test */
    public function a_certificate_can_not_be_updated_by_signedInUser()
    {
        $this->signInUser();

        $certificate = factory(Certificate::class)->create(['company_id'=> 1,]);

        $training = factory(Training::class)->create();

        $this->get($certificate->userpath(1, 1).'/edit')->assertStatus(403);

        $response = $this->patch($certificate->userpath(1, 1), $attributes = [
            'training_id'=> 2,
        ]);

        $this->assertDatabaseMissing('certificates', $attributes);

        $response->assertStatus(403);

    }

    /** @test */
    public function signedInAdmin_can_only_access_their_company_certificates_testing_routes()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $training = factory(Training::class)->create();

        $this->get($training->userpath(1))->assertOk();

        $this->get('/1/trainings/1/certificates')->assertOk();;

        $this->get('/3/trainings/1/certificates')->assertRedirect('/login');

    }


    public function a_report_can_be_edited_by_signInAdmin()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $report = factory(Report::class)->create();

        $this->get($report->userpath(1).'/edit')->assertOk();

        $response = $this->patch($report->userpath(1), $attributes = [
            'report_date'=> '1984-08-03',
        ]);

        $this->assertDatabaseHas('reports', $attributes);

        $registry = Registry::where('id', $report->registry_id)->first();

        $response->assertRedirect($registry->userpath(1));

    }

    /** @test */
    public function a_certificate_can_be_destroyed_by_signInAdmin()
    {

        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $certificate = factory(Certificate::class)->create();

        $certificate = Certificate::all()->first();



        $response = $this->delete($certificate->userpath(1,1));

        $this->assertCount(0, Certificate::all());

        $response->assertRedirect('/1/trainings/1/certificates');



    }






}
