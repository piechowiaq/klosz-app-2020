<?php

declare(strict_types=1);

namespace App\Core\Role\Domain\Repository;

use App\Role;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface
{
    /**
     * @param array|string[] $ids
     *
     * @return Collection|Role[]
     */
    public function getManyByIds(array $ids): Collection;
}
