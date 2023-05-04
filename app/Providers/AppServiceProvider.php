<?php

namespace App\Providers;

use App\Models\CategoryService;
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
        $categoryServiceLevel1 = CategoryService::where("level", 1)->where('status', 'active')->where('state', 'noibat')->get();
        $categoryServiceLevel2 = CategoryService::where("level", 2)->where('status', 'active')->where('state', 'noibat')->get();
        View::share(
            [
                'links' => Page::where("type", "link")->where('status', 'active')->orderBy('id', 'ASC')->get(),
                'setting' => $setting,
                'settingConvert' => $settingConvert,
                'slideshows' => $slideshows,
                'categoryServiceLevel1' => $categoryServiceLevel1,
                'categoryServiceLevel2' => $categoryServiceLevel2,
            ]
        );
    }
}
