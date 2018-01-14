<?php

namespace Mohamedathik\PhotoUpload;

use Illuminate\Support\ServiceProvider;
use Mohamedathik\Photoupload\Upload;

class PhotouploadServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Upload::class, function ($app) {
            return new Upload;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
