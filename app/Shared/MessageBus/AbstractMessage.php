<?php

declare(strict_types=1);

namespace App\Shared\MessageBus;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class AbstractMessage implements ShouldQueue, MessageInterface
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
}
