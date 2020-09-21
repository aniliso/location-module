<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = [];

    public static function getAmenities()
    {
        if($amenities = setting('location::amenities')) {
            $amenities = explode(PHP_EOL, $amenities);
            foreach ($amenities as $key => $amenity) {
                if(strpos($amenity, ";")) {
                    $amenity = explode(";", $amenity);
                    $n_amenities[$amenity[0]]['name'] = $amenity[1];
                    $n_amenities[$amenity[0]]['icon'] = array_key_exists(2, $amenity) ? $amenity[2] : "";
                }
            }
            return collect($n_amenities);
        }
        return collect();
    }

    public static function getAmenitiesToArray()
    {
        $amenities = self::getAmenities();
        return $amenities->pluck("name");
    }

    public static function hasAmenity()
    {
        return self::getAmenitiesToArray()->count() > 0 ? true : false;
    }
}
