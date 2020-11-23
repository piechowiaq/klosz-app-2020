<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registry extends Model
{
//    use Searchable;

    protected $guarded = [];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%' . $query . '%');
    }

    public function path()
    {
        return "/admin/registries/{$this->id}";
    }

    public function userpath(Company $company)
    {
        return "/$company/registries/{$this->id}";
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
