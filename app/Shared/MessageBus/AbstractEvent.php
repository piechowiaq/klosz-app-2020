<?php

declare(strict_types=1);

namespace App\Shared\MessageBus;

use function array_map;
use function func_get_args;

abstract class AbstractEvent extends AbstractMessage implements EventInterface
{
    final public function handle(): void
    {
        $subscribers = array_map(static function (EventSubscriberInterface $subscriber) {
            return $subscriber;
        }, func_get_args());
        foreach ($subscribers as $subscriber) {
            $subscriber($this);
        }
    }
}
