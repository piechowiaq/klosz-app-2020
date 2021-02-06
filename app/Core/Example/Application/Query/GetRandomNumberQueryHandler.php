<?php

declare(strict_types=1);

namespace App\Core\Example\Application\Query;

use function dd;

class GetRandomNumberQueryHandler
{
    public function __invoke(GetRandomNumberQuery $query): int
    {
        dd($query);
    }
}
