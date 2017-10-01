<?php

namespace Modules\Location\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Sidebar\AbstractAdminSidebar;

class RegisterLocationSidebar extends AbstractAdminSidebar
{
    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('location::locations.title.locations'), function (Item $item) {
                $item->icon('fa fa-map-marker');
                $item->weight(0);
                $item->append('admin.location.location.create');
                $item->route('admin.location.location.index');
                $item->authorize(
                    $this->auth->hasAccess('location.locations.index')
                );
            });
        });

        return $menu;
    }
}
