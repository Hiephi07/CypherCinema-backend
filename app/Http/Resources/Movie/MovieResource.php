<?php

namespace App\Http\Resources\Movie;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->image,
            'classify' => $this->classify ? $this->classify->name : null,
            'language' => $this->language ? $this->language->name : null,
            'format' => $this->format ? $this->format->name : null,
            'category' => $this->category ? $this->category->name : null,
        ];
    }
}
