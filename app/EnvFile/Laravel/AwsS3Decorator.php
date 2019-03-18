<?php

namespace App\EnvFile\Laravel;

use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\AwsS3v3\AwsS3Adapter;

class AwsS3Decorator extends AwsS3Adapter
{
    protected $config = [];

    protected $filesystem;

    public function __construct(FilesystemAdapter $filesystem, array $config = [])
    {
        $this->config = $config;
        $this->filesystem = $filesystem;

        $adapter = $filesystem->getDriver()->getAdapter();
        parent::__construct($adapter->getClient(), $adapter->getBucket(), $adapter->getPathPrefix(), $this->config);
    }

    /**
     * Return the underlying filesystem
     *
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    public function read($path, $version = null)
    {
        if ($version == null) {
            return $this->getFilesystem()->read($path);
        }

        $this->options['VersionId'] = $version;
        $response = parent::read($path);
        unset($this->options['VersionId']);

        return data_get($response, 'contents');
    }
}
