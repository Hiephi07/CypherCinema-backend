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
            "id" => $this->id ?? null,
            "image" => $this->image ? url('public/storage/banners/' . $this->image) : null,
            "type" => $this->type ?? null,
            "status" => (bool) $this->status ?? null,
        ];
    }
}
