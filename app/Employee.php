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

    public function userpath($companyId)
    {
        return "/$companyId/employees/{$this->id}";
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class);
    }

    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->surname;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function certificates()
    {
        return $this->belongsToMany(Certificate::class);
    }
    public function getTrainingsCountAttribute(){

        return $this->trainings()->count();
    }
}
