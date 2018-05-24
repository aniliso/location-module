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
        $location = $this->location->findBySlug($slug);
        return view('location::widgets.'.$view, compact('location'));
    }

    public function locations($view='', $limit=20, $except='')
    {
        $locations = $this->location->all()->take($limit)->except($except);
        return view('location::widgets.'.$view, compact('locations'));
    }
}