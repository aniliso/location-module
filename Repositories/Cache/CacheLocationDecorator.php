<?php

namespace Modules\Location\Repositories\Cache;

use Modules\Location\Repositories\LocationRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheLocationDecorator extends BaseCacheDecorator implements LocationRepository
{
    public function __construct(LocationRepository $location)
    {
        parent::__construct();
        $this->entityName = 'location.locations';
        $this->repository = $location;
    }
}
