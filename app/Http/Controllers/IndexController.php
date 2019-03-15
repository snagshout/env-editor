<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EnvFile\EnvFileStorageInterface;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EnvFileRequest;

class IndexController extends Controller
{
    protected $storage;

    protected $request;

    protected $data = [];

    public function __construct(EnvFileStorageInterface $storage, Request $request)
    {
        $this->storage = $storage;
        $this->request = $request;
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

        return redirect()->route('edit_env_file', ['file' => $input['path']]);
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

        return redirect()->route('edit_env_file', ['file' => $input['path']]);
    }

    public function destroy()
    {
        $name = $this->request->get('file');

        if ($name != false) {
            $this->storage->delete($name);
        }

        return redirect()->route('list_env_files');
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
