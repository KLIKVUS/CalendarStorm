<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'active' => $this->whenNotNull($this->active, true),

            'name' => $this->name,

            'rights_of_the_current_user' => [
                $this->attributes(['is_user_can_update']),
                $this->attributes(['is_user_can_delete']),
            ],
        ];
    }
}
