<?php

declare(strict_types=1);

namespace App\Core\Role\Infrastructure\Repository;

use App\Core\Role\Domain\Repository\RoleRepositoryInterface;
use App\Role;
use Illuminate\Database\Eloquent\Collection;

class EloquentRoleRepository implements RoleRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getManyByIds(array $ids): Collection
    {
        return Role::whereIn('id', $ids)->get();
    }
}
