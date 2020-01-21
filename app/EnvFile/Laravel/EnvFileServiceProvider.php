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
        $this->app->bind(
            'env.aws.decorator',
            function ($app) {
                config()->set(
                    'filesystems.disks.s3.bucket',
                    request()->get('bucket', config('filesystems.disks.s3.bucket'))
                );
                $filesystem = $app[FilesystemFactory::class]->disk('s3');
                $config = $app['config']["filesystems.disks.s3"];

                return new AwsS3Decorator($filesystem, $config);
            }
        );

        $this->app->bind(
            EnvFileStorageInterface::class,
            function ($app) {
                return new Storage($app['env.aws.decorator']);
            }
        );
    }
}
