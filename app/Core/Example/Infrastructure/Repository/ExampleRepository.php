<?php

declare(strict_types=1);

namespace App\Core\Example\Infrastructure\Repository;

use App\Core\Example\Domain\Model\Dto\SampleDtoModel;
use App\Core\Example\Domain\Repository\ExampleRepositoryInterface;

use function rand;

class ExampleRepository implements ExampleRepositoryInterface
{
    public function getRandomModel(): SampleDtoModel
    {
        return new SampleDtoModel(
            (string) rand(1, 999),
            'someName'
        );
    }
}
