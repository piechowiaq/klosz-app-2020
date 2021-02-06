<?php

declare(strict_types=1);

namespace App\Core\Example\Infrastructure\Factory;

use App\Core\Example\Domain\Factory\SampleModelFactoryInterface;
use App\Core\Example\Domain\Model\Dto\SampleDtoModel;
use App\Core\Example\Domain\Model\SampleModel;

class SampleModelFactory implements SampleModelFactoryInterface
{
    public function createSampleModel(SampleDtoModel $dtoModel): SampleModel
    {
        return new SampleModel(
            $dtoModel->getId(),
            $dtoModel->getName()
        );
    }
}
