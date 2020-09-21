<?php

namespace Modules\Location\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Localization\Entities\City;
use Modules\Localization\Entities\Country;
use Modules\Location\Presenters\LocationPresenter;
use Modules\Media\Support\Traits\MediaRelation;

class Location extends Model
{
    use Translatable, PresentableTrait, MediaRelation;

    protected $table = 'location__locations';
    public $translatedAttributes = ['name', 'slug', 'phone1', 'phone2', 'mobile', 'fax', 'email'];
    protected $fillable = ['country_id', 'city_id', 'name', 'slug', 'address', 'lat', 'long', 'phone1', 'phone2', 'mobile', 'fax', 'email', 'postcode', 'ordering', 'status', 'settings'];
    protected $presenter = LocationPresenter::class;
    protected $casts = [
      'settings' => 'object'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class)->with('translations');
    }
}
