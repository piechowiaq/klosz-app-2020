<?php

declare(strict_types=1);

namespace App\Core\Company\Infrastructure\Repository;

use App\Company;
use App\Core\Company\Domain\Repository\CompanyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentCompanyRepository implements CompanyRepositoryInterface
{
    public function getById(string $id): Company
    {
        return Company::find($id);
    }

    /**
     * @inheritDoc
     */
    public function getManyByIds(array $ids): Collection
    {
        return Company::whereIn('id', $ids)->get();
    }
}
