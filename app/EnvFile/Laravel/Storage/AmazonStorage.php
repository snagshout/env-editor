<?php

namespace App\EnvFile\Laravel\Storage;

use App\EnvFile\EnvFileStorageInterface;
use App\EnvFile\Laravel\Storage\AbstractStorage;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\EnvFile\Laravel\AwsS3Decorator;
use App\EnvFile\EnvFile;

class AmazonStorage extends AbstractStorage implements EnvFileStorageInterface
{
    protected $filesystem;

    protected $rootPath;

    protected $adapter;

    public function __construct(AwsS3Decorator $adapter)
    {
        $this->filesystem = $adapter->getFilesystem();
        $this->adapter = $adapter;

        if ($root != false) {
            $this->setRootPath($adapter->getBucket());
        }
    }

    public function setRootPath($path)
    {
        $this->adapter->setBucket($path);
        $this->rootPath = $path;
    }

    public function read($path, $version = null)
    {
        $contents = $this->adapter->read($path, $version);
        $contents = $this->parseContents($contents);

        return new EnvFile($path, $contents);
    }

    public function getVersions($path)
    {
        $bucket = $this->adapter->getBucket();
        $client = $this->adapter->getClient();

        $response = $client->listObjectVersions([
            'Bucket' => $bucket,
            'Prefix' => $path
        ]);

        return $this->normalizeVersions($response);
    }

    protected function normalizeVersions($response)
    {
        $versions = $response['Versions'];
        $data = [];

        foreach ($versions as $version) {
            $data[] = [
                'date' => $version['LastModified'],
                'version' => $version['VersionId'],
            ];
        }

        return $data;
    }
}
