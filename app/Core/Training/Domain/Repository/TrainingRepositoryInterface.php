<?php

declare(strict_types=1);

namespace App\Core\Training\Domain\Repository;

use App\Training;

interface TrainingRepositoryInterface
{
    public function getById(string $id): ?Training;
}
