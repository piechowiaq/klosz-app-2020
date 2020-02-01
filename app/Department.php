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
}
