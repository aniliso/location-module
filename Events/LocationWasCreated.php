<?php

namespace Modules\Location\Events;

use Modules\Media\Contracts\StoringMedia;

class LocationWasCreated implements StoringMedia
{
    private $location;
    /**
     * @var array
     */
    private $data;

    /**
     * LocationWasCreated constructor.
     * @param $location
     * @param array $data
     */
    public function __construct($location, array $data)
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
        // TODO: Implement getEntity() method.
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
        // TODO: Implement getSubmissionData() method.
    }
}
