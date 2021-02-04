<?php

declare(strict_types=1);

namespace App\Shared\MessageBus;

interface EventSubscriberInterface
{
    public function __invoke(EventInterface $event): void;
}
