<?php

namespace App\EnvFile\Laravel\Storage;

use App\EnvFile\EnvFileStorageInterface;
use App\EnvFile\Laravel\Storage\AbstractStorage;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;

class LocalStorage extends AbstractStorage implements EnvFileStorageInterface
{
    protected $filesystem;

    protected $rootPath;

    public function __construct(FilesystemFactory $filesystem, $root = null)
    {
        $this->filesystem = $filesystem->disk('local');

        if ($root != false) {
            $this->setRootPath($root);
        }
    }

    public function setRootPath($path)
    {
        $root = $this->filesystem->getDriver()->getAdapter()->getPathPrefix();
        $root = str_replace($this->rootPath, '', $root);
        $full = "{$root}{$path}";

        $this->filesystem->getDriver()->getAdapter()->setPathPrefix($full);
        $this->rootPath = $path;
    }
}
