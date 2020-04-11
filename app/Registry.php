<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registry extends Model
{
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
