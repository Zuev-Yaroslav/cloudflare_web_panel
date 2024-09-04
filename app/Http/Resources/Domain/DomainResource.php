<?php

namespace App\Http\Resources\Domain;

use App\Http\Resources\Domain\Setting\SettingResource;
use App\HttpClients\Cloudflare\ZoneHttpClient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DomainResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'settings' => [
                'ssl' => SettingResource::make(ZoneHttpClient::make()
                    ->getSetting($this['id'], 'ssl')['result'])->resolve()
            ]
        ];
    }
}
