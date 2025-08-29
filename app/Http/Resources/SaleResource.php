<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'value' => number_format($this->value, 2, '.', ''),
            'commission' => number_format($this->value * 0.085, 2, '.', ''),
            'sale_date' => $this->sale_date,
            'seller' => new SellerResource($this->whenLoaded('seller')),
        ];
    }
}
