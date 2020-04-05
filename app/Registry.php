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
}
