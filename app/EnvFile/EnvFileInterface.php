<?php

namespace App\EnvFile;

interface EnvFileInterface
{
    /**
     * Get the full file path
     *
     * @return string
     */
    public function path();

    /**
     * Get contents in string
     *
     * @return string
     */
    public function contents();

    /**
     * Create new instance with specified contents
     *
     * @param  array  $contents
     *
     * @return static
     */
    public function withContents(array $contents);

    /**
     * Check if key exists
     *
     * @param  string $key
     *
     * @return bool        [description]
     */
    public function has($key);

    /**
     * Set key
     *
     * @param string $key
     * @param string $value
     */
    public function set($key, $value);

    /**
     * Get key
     *
     * @param  string $key
     * @param  mixed $default
     *
     * @return string
     */
    public function get($key, $default = null);

    /**
     * Delet ekey
     *
     * @param  string $key
     *
     * @return bool
     */
    public function delete($key);

    /**
     * Get contents in an array of lines
     *
     * @return array
     */
    public function toArray();
}
