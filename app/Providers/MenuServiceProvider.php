<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // get all data from menu.json file
        $verticalMenuJson = file_get_contents(base_path('resources/json/verticalMenu.json'));
        $verticalMenuData = json_decode($verticalMenuJson);
        $horizontalMenuJson = file_get_contents(base_path('resources/json/horizontalMenu.json'));
        $horizontalMenuData = json_decode($horizontalMenuJson);

        // get all artist data from menu.json file
        $verticalMenuJsonUser = file_get_contents(base_path('resources/json/verticalMenu-user.json'));
        $verticalMenuDataUser = json_decode($verticalMenuJsonUser);
        $horizontalMenuJsonUser = file_get_contents(base_path('resources/json/horizontalMenu-user.json'));
        $horizontalMenuDataUser = json_decode($horizontalMenuJsonUser);

        // share all menuData to all the views
        \View::share('menuData', [$verticalMenuData, $horizontalMenuData]);
        \View::share('menuDataUser', [$verticalMenuDataUser, $horizontalMenuDataUser]);

    }
}
