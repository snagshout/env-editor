<?php

namespace App\Http\Middleware;

use Closure;
use App\EnvFile\EnvFileStorageInterface;

class EnvNormalize
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
        $lines = $request->get('lines', []);
        $contents = [];

        foreach ($lines as $line) {
            $contents[$line['key']] = $line['value'];
        }

        $request['lines'] = $contents;

        return $next($request);
    }
}
