<?php

namespace App\Http\Resources\PageRule;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageRuleResource extends JsonResource
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
            'actions' => $this['actions'],
            'status' => $this['status'],
            'targets' => $this['targets'],
        ];
    }
}
