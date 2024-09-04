<?php

namespace App\HttpClients\Cloudflare;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class HttpClient
{
    protected PendingRequest $http;
    private static array $instances = [];
    private static function getInstance(): self
    {
        if (!isset(self::$instances[static::class])) {
            self::$instances[static::class] = new static();
        }
        return self::$instances[static::class];
    }
    public static function make() : self
    {
        return static::getInstance();
    }
    public function auth(array $data): self
    {
        $this->http->replaceHeaders([
                'X-Auth-Email' => $data['email'],
                'X-Auth-Key' => $data['api_key'],
            ]);
        return $this;
    }
    private function __construct()
    {
        $this->http = Http::cloudflare();
    }

}
