<?php

namespace App\Http\Resources\Voucher;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
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
            "name" => $this->name ?? null,
            "discount" => $this->discount ?? null,
            "quantity" => $this->quantity ?? null,
            "status" => (bool) $this->status ?? null,
            "expiration_date" => $this->expiration_date ?? null,
        ];
    }
}
