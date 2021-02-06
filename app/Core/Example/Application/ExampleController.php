<?php

declare(strict_types=1);

namespace App\Core\Example\Application;

use App\Core\Example\Application\Query\GetRandomModelQuery;
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
}
