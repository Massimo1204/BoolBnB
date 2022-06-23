<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    public $timestamps = false;
    public function apartment(){
        return $this->belongsTo('App\Model\Apartment');
    }
}
