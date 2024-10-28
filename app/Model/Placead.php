<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Placead extends Model
{
    protected $fillable = ['placeid','image','ads_link'];
    
    public function city(){
        return $this->belongsTo('App\Model\City');
    }
    public function place(){
        return $this->belongsTo('App\Model\Place','placeid','id');
    }
}
