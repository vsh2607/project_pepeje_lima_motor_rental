<?php

namespace App\Providers;


use App\Models\MasterMenu;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (Auth::check() == false) return;
            $menus = MasterMenu::where('is_hidden', 0)->orderBy('priority', 'ASC')->get();

            //Menu Utama
            foreach ($menus as $item) {
                if ($item->level == 0 && $item->is_dropdown == 0) {
                    $event->menu->add(
                        [
                            'text' => $item->title,
                            'url' => $item->code,
                            'icon' => $item->icon,
                        ],
                    );
                } else {
                    $submenus = MasterMenu::where('level', $item->id)->where('is_hidden', 0)->orderBy('priority', 'ASC')->get();
                    $submenu_arr = [];
                    foreach ($submenus as $submenu) {
                        array_push($submenu_arr, [
                            'text' => $submenu->title,
                            'url' => $item->code . '/' . $submenu->code,
                            'icon' => $submenu->icon,
                        ]);
                    }

                    $event->menu->add(
                        [
                            'text' => $item->title,
                            'icon' => $item->icon,
                            'submenu' => $submenu_arr,
                        ],
                    );
                }
            }
        });
    }
}
