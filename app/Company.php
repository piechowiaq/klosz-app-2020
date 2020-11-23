<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded= [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function path()
    {
        return "/admin/companies/{$this->id}";
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }

    public function registries()
    {
        return $this->belongsToMany(Registry::class);
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class);
    }

    public function getRegistries(): Collection
    {
        return $this->registries()->get();
    }

    public function getId(): string
    {
        return (string) $this->getAttribute('id');
    }
}
