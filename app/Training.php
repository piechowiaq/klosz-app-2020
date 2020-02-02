<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/admin/trainings/{$this->id}";
    }
}
