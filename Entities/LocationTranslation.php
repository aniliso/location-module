<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;

class LocationTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'slug'];
    protected $table = 'location__location_translations';
}
