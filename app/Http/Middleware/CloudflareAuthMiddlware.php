<?php

namespace App\Http\Middleware;

use App\HttpClients\Cloudflare\AccountHttpClient;
use App\HttpClients\Cloudflare\PageRuleHttpClient;
use App\HttpClients\Cloudflare\ZoneHttpClient;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CloudflareAuthMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->cloudflareAccount->user->id !== auth()->user()->id) {
            return redirect()->route('cloudflare-accounts.index');
        }
        ZoneHttpClient::make()->auth($request->cloudflareAccount->toArray());
        AccountHttpClient::make()->auth($request->cloudflareAccount->toArray());
        PageRuleHttpClient::make()->auth($request->cloudflareAccount->toArray());
        return $next($request);
    }
}
