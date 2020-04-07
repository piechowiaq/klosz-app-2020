<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function userpath($companyId)
    {
        return "/$companyId/reports/{$this->id}";
    }
}
