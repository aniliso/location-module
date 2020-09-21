<?php

namespace Modules\Location\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Location\Entities\Amenity;
use Modules\Location\Entities\Location;
use Modules\Location\Http\Requests\CreateLocationRequest;
use Modules\Location\Http\Requests\UpdateLocationRequest;
use Modules\Location\Repositories\LocationRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class LocationController extends AdminBaseController
{
    /**
     * @var LocationRepository
     */
    private $location;

    public function __construct(LocationRepository $location)
    {
        parent::__construct();

        $this->location = $location;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $locations = $this->location->all();

        return view('location::admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('location::admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateLocationRequest $request
     * @return Response
     */
    public function store(CreateLocationRequest $request)
    {
        $this->location->create($request->all());

        return redirect()->route('admin.location.location.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('location::locations.title.locations')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Location $location
     * @return Response
     */
    public function edit(Location $location)
    {
        return view('location::admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Location $location
     * @param  UpdateLocationRequest $request
     * @return Response
     */
    public function update(Location $location, UpdateLocationRequest $request)
    {
        $this->location->update($location, $request->all());

        return redirect()->route('admin.location.location.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('location::locations.title.locations')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Location $location
     * @return Response
     */
    public function destroy(Location $location)
    {
        $this->location->destroy($location);

        return redirect()->route('admin.location.location.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('location::locations.title.locations')]));
    }
}
