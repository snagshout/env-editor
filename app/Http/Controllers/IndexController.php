<?php

namespace App\Http\Controllers;

use App\EnvFile\Laravel\Storage\AmazonStorage;
use Illuminate\Http\Request;
use App\EnvFile\EnvFileStorageInterface;
use App\Http\Requests\EnvFileRequest;

class IndexController extends Controller
{
    /**
     * @var AmazonStorage
     */
    protected $storage;

    protected $request;

    protected $data = [];


    public function __construct(
        EnvFileStorageInterface $storage,
        Request $request
    ) {
        $this->storage = $storage;
        $this->request = $request;
        $this->data['bucket'] = $this->storage->getRootPath();
    }

    public function index()
    {
        $this->data['envs'] = $this->storage->files();

        return view('index', $this->data);
    }

    public function edit()
    {
        $file = $this->request->get('file');
        $version = $this->request->get('version', null);
        $file = $this->storage->read($file, $version);

        $this->data['env'] = $file;
        $this->data['envName'] = basename($file->path());

        return view('edit', $this->data);
    }

    public function update(EnvFileRequest $request)
    {
        $input = $request->validated();
        $input['lines'] = normalize_key_value_array($input['lines']);

        $file = $this->storage->read($input['path']);
        $file = $file->withContents($input['lines']);

        $this->storage->write($file);

        return redirect()->route('edit_env_file', ['file' => $input['path'], 'bucket' => $this->data['bucket']]);
    }

    public function create()
    {
        return view('create', $this->data);
    }

    public function store(EnvFileRequest $request)
    {
        $input = $request->validated();
        $input['lines'] = normalize_key_value_array($input['lines']);

        $file = $this->storage->new($input['path'], $input['lines']);
        $this->storage->write($file);

        return redirect()->route('edit_env_file', ['file' => $input['path'], 'bucket' => $this->data['bucket']]);
    }

    public function destroy()
    {
        $name = (string) $this->request->get('file');

        if ($name) {
            $this->storage->delete($name);
        }

        return redirect()->route('list_env_files', ['bucket' => $this->data['bucket']]);
    }

    public function history()
    {
        $file = $this->request->get('file');
        $env = $this->storage->read($file);

        $this->data['env'] = $env;
        $this->data['envName'] = $file;
        $this->data['versions'] = $this->storage->getVersions($file);

        return view('history', $this->data);
    }
}
