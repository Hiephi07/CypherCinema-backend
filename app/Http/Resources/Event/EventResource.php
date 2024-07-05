<?php

namespace App\Http\Resources\Event;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                "id" => $this->id ?? null,
                "title" => $this->title ?? null,
                "title_sub" => $this->title_sub ?? null,
                "image" => $this->image ?? null,
                "content" => $this->content ?? null,
                "status" => $this->status ?? null,
            ],
        ];
    }
}
