<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function apartments(){
        return $this->belongsToMany('App\Model\Apartment');
    }
}
