<?php

namespace Modules\Location\Events;

use Modules\Media\Contracts\DeletingMedia;

class LocationWasDeleted implements DeletingMedia
{
    private $locationId;
    private $locationClass;

    public function __construct($locationId, $locationClass)
    {

        $this->locationId = $locationId;
        $this->locationClass = $locationClass;
    }

    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId()
    {
        return $this->locationId;
    }

    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName()
    {
        return $this->locationClass;
    }
}
