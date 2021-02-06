<?php

declare(strict_types=1);

namespace App\Core\Example\Application\Query;

use App\Shared\MessageBus\AbstractQuery;

class GetRandomNumberQuery extends AbstractQuery
{
    private int $startNumber;
    private int $endNumber;

    public function __construct(int $startNumber, int $endNumber)
    {
        $this->startNumber = $startNumber;
        $this->endNumber   = $endNumber;
    }

    public function handle(GetRandomNumberQueryHandler $handler): int
    {
        return $handler($this);
    }

    public function getStartNumber(): int
    {
        return $this->startNumber;
    }

    public function getEndNumber(): int
    {
        return $this->endNumber;
    }
}
