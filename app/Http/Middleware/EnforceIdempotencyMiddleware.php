<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class EnforceIdempotencyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $headerName = config('request.idempotency.header_name', 'x-idempotency-key');
        $ttl = config('request.idempotency.cache_ttl', 300);
        $prefix = config('request.idempotency.cache_prefix', 'idempotency_key:');

        if (!config('request.idempotency.enabled')) {
            return $next($request);
        }

        $key = $request->header($headerName);
        if (!$key) {
            return response()->json(['message' => 'Request must use idempotency'], 409);
        }

        $idempotencyKey = Cache::get($prefix . $key);
        if ($idempotencyKey) {
            return response()->json(['message' => 'Duplicate request'], 409);
        } else {
            $idempotencyKey = Cache::set($prefix . $key, true, $ttl);
        }

        return $next($request);
    }
}
