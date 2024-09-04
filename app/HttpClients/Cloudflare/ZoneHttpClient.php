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
class ZoneHttpClient extends HttpClient
{
    private const ENDPOINT_INDEX = '/zones';
    public function index() : Collection
    {
        $result = Cache::remember('zones', now()->addMinutes(5), function () {
            return $this->http->get(self::ENDPOINT_INDEX)->collect();
        });
        CloudflareApiException::checkIfFails($result);
        return $result;
    }
    public function show(string $zoneId) : Collection
    {
        $result = Cache::remember("zones:$zoneId", now()->addMinutes(5), function () use ($zoneId) {
            return $this->http->get(self::ENDPOINT_INDEX . "/$zoneId")->collect();
        });
        CloudflareApiException::checkIfFails($result);
        return $result;
    }
    public function store(array $data) : Collection
    {
        $result = $this->http->post(self::ENDPOINT_INDEX, $data)->collect();
        CloudflareApiException::checkIfFails($result);
        Cache::flush();
        return $result;
    }
    public function destroy(string $zoneId) : Collection
    {
        $result = $this->http->delete(self::ENDPOINT_INDEX . "/$zoneId")->collect();
        CloudflareApiException::checkIfFails($result);
        Cache::flush();
        return $result;
    }
    public function getSetting(string $zoneId, string $setting_id) : Collection
    {
        $result = Cache::remember("zones:$zoneId:$setting_id", now()->addMinutes(5), function () use ($zoneId, $setting_id) {
            return $this->http->get(self::ENDPOINT_INDEX . "/$zoneId/settings/$setting_id")->collect();
        });
        CloudflareApiException::checkIfFails($result);
        return $result;
    }
    public function updateSetting(string $zoneId, $setting_id, $data) : Collection
    {
        $result = $this->http->patch(self::ENDPOINT_INDEX . "/$zoneId/settings/$setting_id", $data)->collect();
        CloudflareApiException::checkIfFails($result);
        Cache::put("zones:$zoneId:$setting_id", $result);
        return $result;
    }
}
