<?php

namespace App\HttpClients\Cloudflare;

use App\Exceptions\Cloudflare\CloudflareApiException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * @mixin HttpClient
 */
class PageRuleHttpClient extends HttpClient
{
    private const ENDPOINT_INDEX = '/zones/';
    private const ENDPOINT_INDEX_2 = '/pagerules';
    public function index(string $zoneId) : Collection
    {
        $result = Cache::remember("zones:$zoneId:pagerules", now()->addMinutes(5), function () use ($zoneId) {
            return $this->http->get(self::ENDPOINT_INDEX . $zoneId . self::ENDPOINT_INDEX_2)->collect();
        });
        CloudflareApiException::checkIfFails($result);
        return $result;
    }
    public function show(string $zoneId, string $pageRuleId) : Collection
    {
        $result = Cache::remember("zones:$zoneId:pagerules:$pageRuleId", now()->addMinutes(5), function () use ($zoneId, $pageRuleId) {
            return $this->http->get(self::ENDPOINT_INDEX . $zoneId .  self::ENDPOINT_INDEX_2 . `/$pageRuleId`)->collect();
        });
        CloudflareApiException::checkIfFails($result);
        return $result;
    }
    public function store(string $zoneId, array $data) : Collection
    {
        $result = $this->http->post(self::ENDPOINT_INDEX . $zoneId .  self::ENDPOINT_INDEX_2, $data)->collect();
        CloudflareApiException::checkIfFails($result);
        Cache::flush();
        return $result;
    }
    public function update(string $zoneId, string $pageRuleId , array $data) : Collection
    {
        $result = $this->http->put(self::ENDPOINT_INDEX . $zoneId .  self::ENDPOINT_INDEX_2 . "/$pageRuleId", $data)->collect();
        CloudflareApiException::checkIfFails($result);
        Cache::flush();
        return $result;
    }
    public function destroy(string $zoneId, string $pageRuleId) : Collection
    {
        $result = $this->http->delete(self::ENDPOINT_INDEX . $zoneId .  self::ENDPOINT_INDEX_2 . "/$pageRuleId")->collect();
        CloudflareApiException::checkIfFails($result);
        Cache::flush();
        return $result;
    }
}
