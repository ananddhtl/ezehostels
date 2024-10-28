<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    public function hostelprices()
    {
        return $this->hasMany('App\Model\HostelPrice');
    }
    public function hostelgallery()
    {
        return $this->hasMany('App\Model\HostelGallery');
    }
    public function hostelservices()
    {
        return $this->hasMany('App\Model\HostelService');
    }
    public function metakey()
    {
        return $this->hasOne('App\Model\MetaKey');
    }
    
}
