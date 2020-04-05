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

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

//    public function scopeCertified($query, $training)
//    {
//        return $query->employees()->whereHas('certificates', function($q) use ($training) {
//            $q->where('expiry_date', '>', \Carbon\Carbon::now())
//                ->where('training_id', $training->id);
//        })->get();
//    }

}
