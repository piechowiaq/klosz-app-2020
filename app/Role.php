<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded= [];

    /**
     * Get the users for the role
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();;
    }

    public function path()
    {
        return "/admin/roles/{$this->id}";
    }


}
