<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'site' => SiteResource::make($this->resource),
            'cancelled_at' => $this->resource->pivot->cancelled_at,
        ];
    }
}
