<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/admin/departments/{$this->id}";
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }
}
