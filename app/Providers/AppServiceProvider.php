<?php

namespace App\Providers;

use App\Model\City;
use App\Model\Hostel;
use App\Model\Logo;
use App\Model\HomeBackgroundImage;
use App\Model\MobileApp;
use App\Model\SiteContact;
use App\Model\SocialMedia;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

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
        Schema::defaultStringLength(191);
        view()->composer('front.layouts.master', function ($view) {
            $view->with([
            'socials'      => SocialMedia::select('image','url')->get(),
            'cities'       => City::select('id','slug','title','show_on_front')->where('show_on_front','yes')->take(6)->get(),
			'allcities'    => City::select('id','slug','title')->get(),
            'site_contact' => SiteContact::select('phone1','phone2','email','address')->first(),
            'mobile_apps'  => MobileApp::select('android_image','android_url','ios_image','ios_url')->first(),
            'logo'         => Logo::select('image')->first(),
            ]);
        });
        
    }
}
