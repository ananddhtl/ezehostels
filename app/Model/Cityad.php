<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cityad extends Model
{
    protected $fillable = ['cityid','image','ads_link'];
    
    public function city(){
        return $this->belongsTo('App\Model\City','cityid','id');
    }
}
