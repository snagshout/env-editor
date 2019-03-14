<?php

namespace App\EnvFile\Laravel\Storage;

use App\EnvFile\EnvFileStorageInterface;
use App\EnvFile\Laravel\Storage\AbstractStorage;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;

class AmazonStorage extends AbstractStorage implements EnvFileStorageInterface
{
    protected $filesystem;

    protected $rootPath;

    public function __construct(FilesystemFactory $filesystem, $root = null)
    {
        $this->filesystem = $filesystem->disk('s3');

        if ($root != false) {
            $this->setRootPath($root);
        }
    }

    public function setRootPath($path)
    {
        $this->filesystem->getDriver()->getAdapter()->setBucket($path);
        $this->rootPath = $path;
    }

    public function getMeta($path)
    {
        $s3 = $this->filesystem->getDriver()->getAdapter();
        return $s3->getMetadata($path->path());
    }
}
