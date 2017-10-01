<?php

namespace Modules\Location\Repositories\Eloquent;

use Modules\Location\Repositories\LocationRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentLocationRepository extends EloquentBaseRepository implements LocationRepository
{
    public function all()
    {
        return $this->model->with(['city', 'country', 'translations'])->get();
    }
}
