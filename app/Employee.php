<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/admin/employees/{$this->id}";
    }
}
