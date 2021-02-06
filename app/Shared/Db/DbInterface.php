<?php

declare(strict_types=1);

namespace App\Shared\Db;

use Illuminate\Database\Query\Builder;

interface DbInterface
{
    public const LT   = '<';
    public const GTE  = '>=';
    public const NEQ  = '<>';
    public const LTE  = '<=';
    public const EQ   = '=';
    public const GT   = '>';
    public const ASC  = 'asc';
    public const DESC = 'desc';

    public function table(string $table, ?string $as = null): Builder;

    public function setConnectionByName(string $name): void;
}
