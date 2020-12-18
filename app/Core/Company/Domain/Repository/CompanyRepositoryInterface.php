<?php

declare(strict_types=1);

namespace App\Core\Company\Domain\Repository;

use App\Company;
use Illuminate\Database\Eloquent\Collection;

interface CompanyRepositoryInterface
{
    public function getById(string $id): Company;

    /**
     * @param array|string[] $ids
     *
     * @return Collection|Company[]
     */
    public function getManyByIds(array $ids): Collection;
}
