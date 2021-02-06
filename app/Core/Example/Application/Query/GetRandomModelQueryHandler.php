<?php

declare(strict_types=1);

namespace App\Core\Example\Application\Query;

use App\Core\Example\Domain\Factory\SampleModelFactoryInterface;
use App\Core\Example\Domain\Model\SampleModel;
use App\Core\Example\Domain\Repository\ExampleRepositoryInterface;

class GetRandomModelQueryHandler
{
    private ExampleRepositoryInterface $exampleRepository;
    private SampleModelFactoryInterface $sampleModelFactory;

    public function __construct(ExampleRepositoryInterface $exampleRepository, SampleModelFactoryInterface $sampleModelFactory)
    {
        $this->exampleRepository  = $exampleRepository;
        $this->sampleModelFactory = $sampleModelFactory;
    }

    public function __invoke(GetRandomModelQuery $query): SampleModel
    {
        $dto = $this->exampleRepository->getRandomModel();

        return $this->sampleModelFactory->createSampleModel($dto);
    }
}
