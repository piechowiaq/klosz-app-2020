<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Registry extends Model
{
    use Searchable;

    protected $guarded = [];

    public function path()
    {
        return "/admin/registries/{$this->id}";
    }

    public function userpath($companyId)
    {
        return "/$companyId/registries/{$this->id}";
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
