<?php

namespace App\Http\Resources\Domain\Setting;

use App\HttpClients\Cloudflare\ZoneHttpClient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'value' => $this['value'],
        ];
    }
}
