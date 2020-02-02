<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/admin/positions/{$this->id}";
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }
}
