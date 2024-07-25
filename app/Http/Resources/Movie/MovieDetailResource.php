<?php

namespace App\Http\Resources\Movie;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieDetailResource extends JsonResource
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
            'content' => $this->content,
            'trailer' => $this->trailer,
            'premiere' => $this->premiere,
            'duration' => $this->duration,
            'classify' => $this->classify ? ['name' => $this->classify->name, 'desc' => $this->classify->disc] : null,
            'language' => $this->language ? $this->language->name : null,
            'format' => $this->format ? $this->format->name : null,
            'category' => $this->category ? $this->category->name : null,
            'director' => $this->director ? $this->director->name : null,
            'performers' => $this->performers ? $this->performers->pluck('name') : null
        ];
    }
}
