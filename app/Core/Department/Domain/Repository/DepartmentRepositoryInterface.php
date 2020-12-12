<?php

declare(strict_types=1);

namespace App\Core\Department\Domain\Repository;

use App\Department;
use Illuminate\Database\Eloquent\Collection;

interface DepartmentRepositoryInterface
{
    public function getById(string $id): ?Department;

    /**
     * @param array|string[] $ids
     *
     * @return Collection|Department[]
     */
    public function getByIds(array $ids): Collection;
}
