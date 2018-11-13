<?php

namespace Modules\Location\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Location\Repositories\LocationRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentLocationRepository extends EloquentBaseRepository implements LocationRepository
{
    public function findBySlug($slug)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->whereHas('translations', function (Builder $q) use ($slug) {
                $q->where('slug', $slug);
            })->with(['city', 'country', 'translations'])->first();
        }

        return $this->model->where('slug', $slug)->first();
    }

    public function all()
    {
        return $this->model->with(['city', 'country', 'translations'])->get();
    }
}
