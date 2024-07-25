<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($data): array
    {
        return [
            'status' => true,
            'data' => [
                "email" => $this->email ?? null,
                "fullname" => $this->fullname ?? null,
                "phone_number" => $this->phone_number ?? null,
                "gender" => $this->gender->name ?? null,
                "birthday" => $this->birthday ?? null,
                "city" => $this->city->name ?? null,
            ],
            "msg" => ""
        ];
    }
}
