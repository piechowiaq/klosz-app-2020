<?php

declare(strict_types=1);

namespace App\Core\Example\Application;

use App\Core\Example\Application\Query\GetRandomModelQuery;
use App\Core\Example\Application\Query\GetRandomNumberQuery;
use App\Shared\MessageBus\MessageBusInterface;

use function dd;

class ExampleController
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function index(): void
    {
        $query  = new GetRandomModelQuery();
        $result = $this->messageBus->dispatchSyncQuery($query);
        dd($result);
    }

    public function randomNumber(): int
    {
        $query = new GetRandomNumberQuery(1, 9);

        return $this->messageBus->dispatchSyncQuery($query);
    }
}
