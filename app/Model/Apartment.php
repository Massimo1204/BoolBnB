<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function pictures(){
        return $this->hasMany('App\Model\Picture');
    }

    public function views(){
        return $this->hasMany('App\Model\View');
    }

    public function messages(){
        return $this->hasMany('App\Model\Message');
    }

    public function sponsorships(){
        return $this->belongsToMany('App\Model\Sponsorship');
    }

    public function services(){
        return $this->belongsToMany('App\Model\Service');
    }
}
