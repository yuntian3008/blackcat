<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\View;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

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

        Validator::extend('base64_image', function ($attribute, $value, $parameters, $validator) {

            $base64data = $value;
            $allowedMime =  ['png', 'jpg', 'jpeg', 'gif'];
            // strip out data uri scheme information (see RFC 2397)
            if (strpos($base64data, ';base64') !== false) {
                list(, $base64data) = explode(';', $base64data);
                list(, $base64data) = explode(',', $base64data);
            }

            // strict mode filters for non-base64 alphabet characters
            if (base64_decode($base64data, true) === false) {
                return false;
            }

            // decoding and then reeconding should not change the data
            if (base64_encode(base64_decode($base64data)) !== $base64data) {
                return false;
            }

            $binaryData = base64_decode($base64data);

            // temporarily store the decoded data on the filesystem to be able to pass it to the fileAdder
            $tmpFile = tempnam(sys_get_temp_dir(), 'medialibrary');
            file_put_contents($tmpFile, $binaryData);

            // guard Against Invalid MimeType
            $allowedMime = Arr::flatten($allowedMime);

            // no allowedMimeTypes, then any type would be ok
            if (empty($allowedMime)) {
                return true;
            }

            // Check the MimeTypes
            $validation = \Illuminate\Support\Facades\Validator::make(
                ['file' => new \Illuminate\Http\File($tmpFile)],
                ['file' => 'mimes:' . implode(',', $allowedMime)]
            );

            return !$validation->fails();
        });
    }
}
