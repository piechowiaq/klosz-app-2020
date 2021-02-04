<?php

declare(strict_types=1);

namespace App\Shared\MessageBus;

interface MessageBusInterface
{
    public function dispatchSyncQuery(QueryInterface $query): mixed;

    public function dispatchAsyncCommand(CommandInterface $command): void;

    public function dispatchSyncCommand(CommandInterface $command): mixed;

    public function dispatchEvent(EventInterface $event): void;
}
