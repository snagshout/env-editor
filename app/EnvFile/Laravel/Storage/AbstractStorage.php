<?php

namespace App\EnvFile\Laravel\Storage;

use App\EnvFile\EnvFile;
use App\EnvFile\EnvFileInterface;
use App\EnvFile\EnvFileStorageInterface;
use Illuminate\Contracts\Filesystem\Filesystem;

abstract class AbstractStorage implements EnvFileStorageInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    protected $rootPath;

    public function getRootPath()
    {
        return $this->rootPath;
    }

    public function setRootPath($path)
    {
        $this->rootPath = $path;
    }

    protected function parseContents($string)
    {
        $lines = explode("\n", $string);
        $contents = [];

        foreach ($lines as $line) {
            if (preg_match('#([^=\s]+)=(.*)#', $line, $match) === 1) {
                list(, $key, $value) = $match;
                $contents[$key] = $value;
            } else {
                $contents[] = $line;
            }
        }

        return $contents;
    }

    public function read($name)
    {
        $contents = $this->filesystem->get($name);
        $contents = $this->parseContents($contents);

        return new EnvFile($name, $contents);
    }

    public function new($name, array $contents = [])
    {
        return new EnvFile($name, $contents);
    }

    public function write(EnvFileInterface $file)
    {
        $contents = $file->contents();
        $path = $file->path();

        return $this->filesystem->put($path, $contents);
    }

    public function files()
    {
        $files = $this->filesystem->allFiles();
        $envs = [];

        foreach ($files as $file) {
            $contents = $this->filesystem->get($file);
            $contents = $this->parseContents($contents);

            $envs[] = new EnvFile($file, $contents);
        }

        return $envs;
    }

    public function delete($name)
    {
        return $this->filesystem->delete($name);
    }

    public function exists($name)
    {
        return $this->filesystem->exists($name);
    }
}
