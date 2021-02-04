<?php

declare(strict_types=1);

namespace App\Shared\MessageBus;

abstract class AbstractEventSubscriber extends AbstractMessage implements EventSubscriberInterface
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    final public function __invoke(EventInterface $event): void
    {
        $command = $this->createCommand($event);
        $this->messageBus->dispatchAsyncCommand($command);
    }

    abstract protected function createCommand(EventInterface $event): CommandInterface;
}
