<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($user): array
    {
        return [
            'status' => true,
            'data' => $this->email,
            'msg'  => "Tạo mới người dùng thành công!"
        ];
    }
}
