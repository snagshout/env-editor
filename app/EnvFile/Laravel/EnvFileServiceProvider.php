<?php

namespace App\EnvFile\Laravel;

use Illuminate\Support\ServiceProvider;
use App\EnvFile\EnvFileStorageInterface;
use App\EnvFile\Laravel\Storage\AmazonStorage as Storage;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;

class EnvFileServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(EnvFileStorageInterface::class, function ($app) {
            // this would be better if I have created a Storage factory
            // instead of manually swapping instances here
            return new Storage($app[FilesystemFactory::class], 'env-examples');
        });
    }
}
