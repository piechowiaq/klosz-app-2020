<?php

namespace App;

use App\Http\Requests\StoreUserReportRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = [];
    /**
     * @var string
     */
    public function userpath($companyId)
    {
        return "/$companyId/reports/{$this->id}";
    }

    public function registry()
    {
        return $this->belongsTo(Registry::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

//    public function setExpiryDateAttribute($value, StoreUserReportRequest $request){
//
//        return $this->attributes['expiry_date'] = Carbon::create(request('report_date'))->addMonths( Registry::where('id', request('registry_id'))->first()->valid_for)->toDateString();
//    }

    public function calculateExpiryDate($report){

        return Carbon::create(request('report_date'))->addMonths( Registry::where('id', request('registry_id'))->first()->valid_for)->toDateString();
    }




}
