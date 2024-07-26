<?php

namespace App\Http\Resources\Theater;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TheaterResource extends JsonResource
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
            'image' => $this->image ? url('public/storage/theaters/'. $this->image) : null,
            'address' => $this->address ?? null,
            'content' => $this->content ?? null,
            'city' => $this->city->name ?? null,
            'phone' => $this->phone ?? null,
            'email' => $this->email ?? null,
        ];
    }
}
