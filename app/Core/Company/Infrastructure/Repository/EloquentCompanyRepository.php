<?php

declare(strict_types=1);

namespace App\Core\Company\Infrastructure\Repository;

use App\Company;
use App\Core\Company\Domain\Repository\CompanyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentCompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getManyByIds(array $ids): Collection
    {
        return Company::whereIn('id', $ids)->get();
    }
}
