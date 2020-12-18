<?php

declare(strict_types=1);

namespace App\Core\Registry\Infrastructure\Repository;

use App\Core\Registry\Domain\Repository\RegistryRepositoryInterface;
use App\Registry;
use Illuminate\Database\Eloquent\Collection;

class EloquentRegistryRepository implements RegistryRepositoryInterface
{
    public function getById(string $id): Registry
    {
        return Registry::find($id);
    }

    /**
     * @inheritDoc
     */
    public function getManyByIds(array $ids): Collection
    {
        return Registry::whereIn('id', $ids)->get();
    }
}
