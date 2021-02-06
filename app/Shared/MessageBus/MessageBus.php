<?php

declare(strict_types=1);

namespace App\Shared\MessageBus;

use Illuminate\Foundation\Bus\DispatchesJobs;

class MessageBus implements MessageBusInterface
{
    use DispatchesJobs;

    public function dispatchSyncQuery(QueryInterface $query): mixed
    {
        return $this->dispatchSync($query);
    }

    public function dispatchAsyncCommand(CommandInterface $command): void
    {
        $this->dispatchAsync($command);
    }

    public function dispatchSyncCommand(CommandInterface $command): mixed
    {
        return $this->dispatchSync($command);
    }

    public function dispatchEvent(EventInterface $event): void
    {
        $this->dispatchAsync($event);
    }

    private function dispatchSync(MessageInterface $message): mixed
    {
        return $this->dispatchNow($message);
    }

    private function dispatchAsync(MessageInterface $message): void
    {
        $this->dispatch($message);
    }
}
