<?php

namespace App\Http\Resources\Banner;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
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
                "image" => $this->image ?? null,
                "status" => $this->status ?? null,
                "type" => $this->type ?? null,
            ],
        ];
    }
}
