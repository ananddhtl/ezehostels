<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HostelGallery extends Model
{
    public function hostel()
    {
        return $this->belongsTo('App\Model\Hostel');
    }
}
