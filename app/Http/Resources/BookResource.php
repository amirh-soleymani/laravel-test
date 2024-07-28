<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'activity_id' => $this->activity_id,
            'user_name' => $this->user_name,
            'user_email' => $this->user_email,
            'slots_booked' => $this->slots_booked,
            'status' => $this->status
        ];
    }
}
