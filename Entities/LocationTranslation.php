<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;

class LocationTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'slug', 'phone1', 'phone2', 'mobile', 'fax', 'email'];
    protected $table = 'location__location_translations';
}
