<?php

namespace App\EnvFile;

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

            $key = $this->normalizeKey($key);
            $value = trim($value);
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
        $key = $this->normalizeKey($key);

        if (!is_numeric($key) || $this->has($key)) {
            unset($this->contents[$key]);
        }
    }

    protected function setContents(array $contents)
    {
        foreach ($contents as $key => $value) {
            $this->set($key, $value);
        }
    }

    protected function normalizeKey($key) : string
    {
        $key = mb_strtoupper($key);
        $key = trim($key);

        return $key;
    }

    public function toArray() : array
    {
        return array_filter(
            $this->contents,
            function ($value, $key) {
                return (is_numeric($key) == false);
            },
            ARRAY_FILTER_USE_BOTH
        );
    }
}
