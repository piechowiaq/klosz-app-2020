<?php

declare(strict_types=1);

namespace App\Core\Certificate\Domain\Repository;

use App\Certificate;
use Illuminate\Database\Eloquent\Collection;

interface CertificateRepositoryInterface
{
    public function getById(string $id): ?Certificate;

    /**
     * @param array|string[] $ids
     *
     * @return Collection | Certificate[]
     */
    public function getManyByIds(array $ids): Collection;
}
