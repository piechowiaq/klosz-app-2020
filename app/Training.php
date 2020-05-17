<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Training extends Model
{
    use Searchable;

    protected $guarded = [];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%'.$query.'%');
    }

    public function path()
    {
        return "/admin/trainings/{$this->id}";
    }

    public function userpath($companyId)
    {
        return "/$companyId/trainings/{$this->id}";
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

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

//    public function scopeCertified($query, $training)
//    {
//        return $query->employees()->whereHas('certificates', function($q) use ($training) {
//            $q->where('expiry_date', '>', \Carbon\Carbon::now())
//                ->where('training_id', $training->id);
//        })->get();
//    }

}
