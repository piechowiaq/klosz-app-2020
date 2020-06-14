<?php

namespace Tests\Feature;

use App\Company;
use App\Employee;
use App\Registry;
use App\Report;
use App\Training;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SearchTest extends TestCase
{

    use RefreshDatabase;

//    /** @test */
    public function a_user_can_search_employees()
    {
        config(['scout.driver' => 'algolia']);

        $this->signInUser();

        $search = 'foobar';

        factory(Employee::class, 2)->create([
            'company_id' => 1,
        ]);
        factory(Employee::class, 2)->create([
            'company_id' => 1,
            'surname' => "Employee with the {$search} term.",
        ]);
        factory(Employee::class, 1)->create([
            'company_id' => 2,
            'surname' => "Employee with the {$search} term.",
        ]);

        do {
            sleep(3);

            $results = $this->getJson("/1/employees/search?q={$search}")->json();

        } while(empty($results));

        $this->assertCount(2, $results['data']);

        Employee::latest()->take(5)->unsearchable();

    }

//    /** @test */
    public function a_user_can_search_registries()
    {
        config(['scout.driver' => 'algolia']);

        $this->signInUser();

        $search = 'foobar';

        $company1 = Company::findOrfail(1);

        $company2 = factory(Company::class)->create();

        $registry1 = factory(Registry::class)->create();

        $registry2 = factory(Registry::class)->create([
            'name' => "Registry with {$search} term.",
        ]);
        $registry3 = factory(Registry::class)->create([
            'name' => "Registry with {$search} term.",
        ]);

        $company1->registries()->attach([$registry1->id, $registry2->id]);

        $company2->registries()->attach($registry3->id);

        do {
            sleep(3);

            $results = $this->getJson("/1/registries/search?q={$search}")->json();

        } while(empty($results));

        $this->assertCount(1, $results['data']);

        Registry::latest()->take(3)->unsearchable();

    }

//    /** @test */
    public function a_user_can_search_trainings()
    {
        config(['scout.driver' => 'algolia']);

        $this->signInUser();

        $search = 'foobar';

        $company1 = Company::findOrfail(1);

        $company2 = factory(Company::class)->create();

        $training1 = factory(Training::class)->create();

        $training2 = factory(Training::class)->create([
            'name' => "Training with {$search} term.",
        ]);
        $training3 = factory(Training::class)->create([
            'name' => "Training with {$search} term.",
        ]);

        $company1->trainings()->attach([$training1->id, $training2->id]);

        $company2->trainings()->attach($training3->id);

        do {
            sleep(3);

            $results = $this->getJson("/1/trainings/search?q={$search}")->json();

        } while(empty($results));

        $this->assertCount(1, $results['data']);

        Training::latest()->take(3)->unsearchable();

    }

    /** @test */
    public function test_lifewire (){

        $company = factory(Company::class)->create();

        $registry1 = factory(Registry::class)->create(['name' => 'foo']);
        $registry2 = factory(Registry::class)->create(['name' => 'bar']);

        $company->registries()->attach([$registry1->id, $registry2->id ]);

        Livewire::test('search-registries',['company'=> $company])
            ->assertSee('foo')
            ->assertSee('bar')
            ->set('search', 'foo')
            ->assertSee('foo')
            ->assertDontsee('bar');
    }

}
