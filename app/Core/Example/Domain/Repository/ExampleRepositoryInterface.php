<?php

declare(strict_types=1);

namespace App\Core\Example\Domain\Repository;

use App\Core\Example\Domain\Model\Dto\SampleDtoModel;

interface ExampleRepositoryInterface
{
    public function getRandomModel(): SampleDtoModel;
}
