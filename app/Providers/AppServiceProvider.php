<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\View;
use App\Category;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /** 
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {

        if (Schema::hasTable('categories')) {
            View::share('categories', Category::all());
            View::share('root_categories', Category::whereNull('parent_id')->get());
            View::share('recursive_categories',  Category::with('childrenRecursive')->whereNull('parent_id')->get());
        }
        Schema::defaultStringLength(191);
        if(env('REDIRECT_HTTPS')) {
            $url->formatScheme('https');
        }
    }
}
