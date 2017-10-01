<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/location'], function (Router $router) {
    $router->bind('location', function ($id) {
        return app('Modules\Location\Repositories\LocationRepository')->find($id);
    });
    $router->get('locations', [
        'as' => 'admin.location.location.index',
        'uses' => 'LocationController@index',
        'middleware' => 'can:location.locations.index'
    ]);
    $router->get('locations/create', [
        'as' => 'admin.location.location.create',
        'uses' => 'LocationController@create',
        'middleware' => 'can:location.locations.create'
    ]);
    $router->post('locations', [
        'as' => 'admin.location.location.store',
        'uses' => 'LocationController@store',
        'middleware' => 'can:location.locations.create'
    ]);
    $router->get('locations/{location}/edit', [
        'as' => 'admin.location.location.edit',
        'uses' => 'LocationController@edit',
        'middleware' => 'can:location.locations.edit'
    ]);
    $router->put('locations/{location}', [
        'as' => 'admin.location.location.update',
        'uses' => 'LocationController@update',
        'middleware' => 'can:location.locations.edit'
    ]);
    $router->delete('locations/{location}', [
        'as' => 'admin.location.location.destroy',
        'uses' => 'LocationController@destroy',
        'middleware' => 'can:location.locations.destroy'
    ]);
// append

});
