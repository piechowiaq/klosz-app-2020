<?php

declare(strict_types=1);

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
//    use Searchable;

    protected $guarded = [];

//    public static function search($query)
//    {
//        return empty($query) ? static::query()
//            : static::where('name', 'like', '%'.$query.'%')
//                ->orWhere('surname', 'like', '%'.$query.'%');
//    }


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
        return $this->name . ' ' . $this->surname;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function certificates()
    {
        return $this->belongsToMany(Certificate::class);
    }

    public function getTrainingsCountAttribute()
    {
        return $this->trainings()->count();
    }

    public function scopeCertified($query, Training $training, Company $company)
    {
        return $query->where('company_id', $company->getId())->whereHas('certificates', static function ($q) use ($training): void {
            $q->where('expiry_date', '>', Carbon::now())
                ->where('training_id', $training->id);
        })->get();
    }

    public function toSearchableArray()
    {
        return $this->toArray() + ['path' => $this->userpath($this['company_id'])];
    }
}
