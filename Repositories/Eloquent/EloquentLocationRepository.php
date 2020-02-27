<?php

namespace Modules\Location\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Location\Events\LocationWasCreated;
use Modules\Location\Events\LocationWasDeleted;
use Modules\Location\Events\LocationWasUpdated;
use Modules\Location\Repositories\LocationRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentLocationRepository extends EloquentBaseRepository implements LocationRepository
{
    public function create($data)
    {
        $model = $this->model->create($data);
        event(new LocationWasCreated($model, $data));
        return $model;
    }

    public function update($model, $data)
    {
        $model->update($data);
        event(new LocationWasUpdated($model, $data));
        return $model;
    }

    public function destroy($model)
    {
        event(new LocationWasDeleted($model->id, get_class($model)));
        return $model;
    }

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
