<?php

namespace Tests\Feature;

use App\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
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
}
