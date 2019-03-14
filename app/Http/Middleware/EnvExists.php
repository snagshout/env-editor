<?php

namespace App\Http\Middleware;

use Closure;
use App\EnvFile\EnvFileStorageInterface;

class EnvExists
{
    protected $storage;

    public function __construct(EnvFileStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $file = $request->get('file');

        if ($this->storage->exists($file) == false) {
            return redirect()->route('list_env_files');
        }

        return $next($request);
    }
}
