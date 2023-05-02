<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Photo;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Setting::first() !== null ? $setting = Setting::first() : $setting = '';
        // Setting covert from JSON to Array
        json_decode(Setting::first()->options, true) !== null ? $settingConvert = json_decode(Setting::first()->options, true) : $settingConvert = '';
        $slideshows = Photo::where('type', 'slideshow')->orderBy('id', 'ASC')->get();
        View::share(
            [
                'links' => Page::where("type", "link")->where('status', 'active')->orderBy('id', 'ASC')->get(),
                'setting' => $setting,
                'settingConvert' => $settingConvert,
                'slideshows' => $slideshows
            ]
        );
    }
}
