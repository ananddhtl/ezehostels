<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    public function city()
    {
        return $this->belongsTo('App\Model\City');
    }
    public function metakey()
    {
    	return $this->hasOne('App\Model\MetaKey');
    }
}
