<?php

declare(strict_types=1);

namespace App\Core\Company\Domain\Repository;

use App\Company;
use Illuminate\Database\Eloquent\Collection;

interface CompanyRepositoryInterface
{
    /**
     * @param array|string[] $ids
     *
     * @return Collection|Company[]
     */
    public function getManyByIds(array $ids): Collection;
}
