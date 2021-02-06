<?php

declare(strict_types=1);

namespace App\Shared\MessageBus;

abstract class AbstractCommand extends AbstractMessage implements CommandInterface
{
}
