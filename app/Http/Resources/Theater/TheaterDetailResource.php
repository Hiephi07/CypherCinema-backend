<?php

namespace App\Http\Resources\Theater;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TheaterDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? null,
            'name' => $this->name ?? null,
            'image' => $this->image ?? null,
            'address' => $this->address ?? null,
            'content' => $this->content ?? null,
        ];
    }
}
