<?php

declare(strict_types=1);

namespace App\Core\Training\Infrastructure\Repository;

use App\Core\Training\Domain\Repository\TrainingRepositoryInterface;
use App\Training;

class EloquentTrainingRepository implements TrainingRepositoryInterface
{
    public function getById(string $id): Training
    {
        return Training::find($id);
    }
}
