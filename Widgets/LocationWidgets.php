<?php namespace Modules\Location\Widgets;


use Modules\Location\Repositories\LocationRepository;

class LocationWidgets
{
    /**
     * @var LocationRepository
     */
    private $location;

    public function __construct(LocationRepository $location)
    {
        $this->location = $location;
    }

    public function location($slug='', $view='location')
    {
        if($location = $this->location->findBySlug($slug)) {
            return view('location::widgets.'.$view, compact('location'));
        }
        return "";
    }

    public function locations($view='', $limit=20, $except='')
    {
        $locations = $this->location->all()->where('status', 1)->sortBy('ordering')->take($limit)->except($except);
        if($locations->count()>0) {
            return view('location::widgets.' . $view, compact('locations'));
        }
        return "";
    }
}
