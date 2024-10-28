<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HostelPrice extends Model
{
    public function hostel()
    {
        return $this->belongsTo('App\Model\Hostel');
    }
}
