<?php

namespace App\HttpClients\Cloudflare;

use App\Exceptions\Cloudflare\CloudflareAccountException;
use App\Exceptions\Cloudflare\CloudflareApiException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * @mixin HttpClient
 */
class AccountHttpClient extends HttpClient
{
    private const ENDPOINT_INDEX = '/accounts';
    public function index() : Collection
    {
        $result = $this->http->get(self::ENDPOINT_INDEX)->collect();
        CloudflareApiException::checkIfFails($result);
        return $result;
    }
    public function show(string $accountId) : Collection
    {
        $result = $this->http->get(self::ENDPOINT_INDEX . '/' . $accountId)->collect();
        CloudflareApiException::checkIfFails($result);
        return $result;
    }
}
