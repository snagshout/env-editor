<?php

namespace App\EnvFile;

use App\EnvFile\EnvFileInterface;

class EnvFile implements EnvFileInterface
{
    protected $path = null;

    public $contents = [];

    public function __construct($path, array $contents = [])
    {
        $this->path = $path;

        $this->setContents($contents);
    }

    public function path()
    {
        return $this->path;
    }

    public function contents()
    {
        $contents = '';

        foreach ($this->contents as $key => $value) {
            if (is_numeric($key) == true) {
                $contents .= "$value" . PHP_EOL;
                continue;
            }
            $contents .= "{$key}={$value}" . PHP_EOL;
        }

        return trim($contents);
    }

    public function withContents(array $contents)
    {
        return new static($this->path, $contents);
    }

    public function has($key)
    {
        $key = $this->normalizeKey($key);

        return isset($this->contents[$key]);
    }

    public function set($key, $value)
    {
        $key = $this->normalizeKey($key);
        $value = trim($value);

        if (is_numeric($key) == false) {
            $this->contents[$key] = $value;
        }
    }

    public function get($key, $default = null)
    {
        $key = $this->normalizeKey($key);

        if (is_numeric($key) == true || $this->has($key) == false) {
            return $default;
        }

        return $this->contents[$key];
    }

    public function delete($key)
    {
        if (is_numeric($key) == false || $this->has($key) == true) {
            unset($this->contents[$key]);
        }
    }

    protected function setContents(array $contents)
    {
        if ($contents == false) {
            return false;
        }

        $this->contents = $contents;
    }

    protected function normalizeKey($key)
    {
        $key = mb_strtoupper($key);
        $key = trim($key);

        return $key;
    }

    public function toArray()
    {
        return array_filter($this->contents, function ($value, $key) {
            return (is_numeric($key) == false);
        }, ARRAY_FILTER_USE_BOTH);
    }
}
