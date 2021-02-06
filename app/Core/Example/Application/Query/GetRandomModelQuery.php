<?php

declare(strict_types=1);

namespace App\Core\Example\Application\Query;

use App\Core\Example\Domain\Model\SampleModel;
use App\Shared\MessageBus\AbstractQuery;

class GetRandomModelQuery extends AbstractQuery
{
    public function handle(GetRandomModelQueryHandler $handler): SampleModel
    {
        return $handler($this);
    }
}
