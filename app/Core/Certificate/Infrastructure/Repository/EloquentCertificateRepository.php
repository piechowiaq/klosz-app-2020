<?php

declare(strict_types=1);

namespace App\Core\Certificate\Infrastructure\Repository;

use App\Certificate;
use App\Core\Certificate\Domain\Repository\CertificateRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentCertificateRepository implements CertificateRepositoryInterface
{
    public function getById(string $id): ?Certificate
    {
        return Certificate::find($id);
    }

    /**
     * @inheritDoc
     */
    public function getManyByIds(array $ids): Collection
    {
        return Certificate::whereIn('id', $ids)->get();
    }
}
