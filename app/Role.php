<?php declare(strict_types = 1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $guarded= [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function path()
    {
        return "/admin/roles/{$this->id}";
    }

    public static function create(array $array): void
    {
        self::create(array $array);
    }

}
