<?php

namespace App\EnvFile;

interface EnvFileStorageInterface
{
    /**
     * Read env file
     *
     * @param  string $name
     *
     * @return EnvFileInterface
     */
    public function read($name);

    /**
     * Create new env file
     *
     * @param  string $name
     * @param  array  $contents
     *
     * @return EnvFileInterface
     */
    public function new($name, array $contents = []);

    /**
     * Write env file to disk
     *
     * @param  EnvFileInterface $file
     *
     * @return bool
     */
    public function write(EnvFileInterface $file);

    /**
     * Get all env files
     *
     * @return EnvFileInterface[]
     */
    public function files();

    /**
     * Delete env file
     *
     * @param  string $name
     *
     * @return bool
     */
    public function delete($name);

    /**
     * Check if env file exists
     *
     * @param  string $name
     *
     * @return bool
     */
    public function exists($name);

    /**
     * Get root storage path
     *
     * @return string
     */
    public function getRootPath();

    /**
     * Set root storage path
     *
     * @param string $path
     */
    public function setRootPath($path);
}
