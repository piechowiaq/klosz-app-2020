<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/admin/certificates/{$this->id}";
    }
}
