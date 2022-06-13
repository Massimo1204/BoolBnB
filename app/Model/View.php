<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    public function apartment(){
        return $this->belongsTo('App\Model\Apartment');
    }
}
