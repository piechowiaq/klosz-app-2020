<?php

declare(strict_types=1);

namespace App\Shared\Db;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;

class Db implements DbInterface
{
    private DatabaseManager $databaseManager;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    public function table(string $table, ?string $as = null): Builder
    {
        return $this->databaseManager->table($table, $as);
    }

    public function setConnectionByName(string $name): void
    {
        $this->databaseManager->connection($name);
    }
}
