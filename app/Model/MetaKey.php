<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MetaKey extends Model
{
    public function city()
    {
        return $this->belongsTo('App\Model\City');
    }
    public function place()
    {
        return $this->belongsTo('App\Model\Place');
    }
    public function hostel()
    {
        return $this->belongsTo('App\Model\Hostel');
    }
}
