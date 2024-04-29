<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'active' => $this->whenNotNull($this->active, true),

            'name' => $this->name,
            'description' => $this->description,
            'link' => $this->link,
            'color' => $this->color,
            'beginning' => $this->beginning,
            'ending' => $this->ending,
        ];
    }
}
