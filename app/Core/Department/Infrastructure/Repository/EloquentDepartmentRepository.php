<?php

declare(strict_types=1);

namespace App\Core\Department\Infrastructure\Repository;

use App\Core\Department\Domain\Repository\DepartmentRepositoryInterface;
use App\Department;
use Illuminate\Database\Eloquent\Collection;

class EloquentDepartmentRepository implements DepartmentRepositoryInterface
{
    public function getById(string $id): ?Department
    {
        return Department::find($id);
    }

    /**
     * @inheritDoc
     */
    public function getManyByIds(array $ids): Collection
    {
        return Department::whereIn('id', $ids)->get();
    }
}
