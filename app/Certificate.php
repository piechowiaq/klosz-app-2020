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

    public function userpath(Company $company, Training $training):
    {
        return "/$company/trainings/$training/certificates/{$this->id}";
    }

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }


}
