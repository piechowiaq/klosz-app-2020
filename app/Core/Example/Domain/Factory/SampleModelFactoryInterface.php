<?php

declare(strict_types=1);

namespace App\Core\Example\Domain\Factory;

use App\Core\Example\Domain\Model\Dto\SampleDtoModel;
use App\Core\Example\Domain\Model\SampleModel;

interface SampleModelFactoryInterface
{
    public function createSampleModel(SampleDtoModel $dtoModel): SampleModel;
}
