<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Registry extends Model
{
//    use Searchable;

    protected $guarded = [];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%'.$query.'%');
    }

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

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }
}
