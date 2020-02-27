<?php

namespace Modules\Location\Events;

use Modules\Location\Entities\Location;
use Modules\Media\Contracts\StoringMedia;

class LocationWasUpdated implements StoringMedia
{
    /**
     * @var Location
     */
    private $location;
    /**
     * @var array
     */
    private $data;

    public function __construct(Location $location, array $data)
    {

        $this->location = $location;
        $this->data = $data;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->location;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
