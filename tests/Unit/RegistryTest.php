<?php

namespace Tests\Unit;

use App\Company;
use App\Registry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function employee_has_a_path()
    {
        $registry = factory(Registry::class)->create();

        $this->assertEquals("/admin/registries/{$registry->id}", $registry->path());
    }




}
