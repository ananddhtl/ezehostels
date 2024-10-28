<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function places()
    {
        return $this->hasMany('App\Model\Place');
    }
    public function metakey()
    {
    	return $this->hasOne('App\Model\MetaKey');
    }
}
