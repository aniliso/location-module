<?php namespace Modules\Location\Presenters;

use Modules\Core\Presenters\BasePresenter;

class LocationPresenter extends BasePresenter
{
    public function address()
    {
        return $this->entity->address . ' ' . $this->entity->city->name . ' ' . $this->entity->country->name;
    }
}