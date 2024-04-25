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
            'active' => $this->when(nullValue($this->active), 1, 0),

            'name' => $this->name,
            'description' => $this->description,
            'link' => $this->link,
            'color' => $this->color,
            'beginning' => $this->beginning->format('d.m.Y'),
            'ending' => $this->ending->format('d.m.Y'),
        ];
    }
}
