<?php

namespace Modules\Location\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Localization\Entities\City;
use Modules\Localization\Entities\Country;
use Modules\Location\Presenters\LocationPresenter;

class Location extends Model
{
    use Translatable, PresentableTrait;

    protected $table = 'location__locations';
    public $translatedAttributes = ['name', 'slug'];
    protected $fillable = ['country_id', 'city_id', 'name', 'slug', 'address', 'lat', 'long', 'phone1', 'phone2', 'fax', 'email', 'postcode', 'ordering', 'status'];
    protected $presenter = LocationPresenter::class;

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->with('translations');
    }

    public function country()
    {
        return $this->belongsTo(Country::class)->with('translations');
    }
}