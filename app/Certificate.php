<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $guarded = [];
    /**
     * @var string
     */

    public function path()
    {
        return "/admin/certificates/{$this->id}";
    }

    public function userpath($companyId)
    {
        return "/$companyId/certificates/{$this->id}";
    }

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
