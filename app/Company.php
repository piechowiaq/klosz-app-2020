<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded= [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function path()
    {
        return "/admin/companies/{$this->id}";
    }

}
