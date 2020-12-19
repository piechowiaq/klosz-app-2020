<?php

declare(strict_types=1);

namespace App\Core\Registry\Domain\Repository;

use App\Registry;
use Illuminate\Database\Eloquent\Collection;

interface RegistryRepositoryInterface
{
    public function getById(string $id): ?Registry;

    /**
     * @param array|string[] $ids
     *
     * @return Collection|Registry[]
     */
    public function getManyByIds(array $ids): Collection;
}
