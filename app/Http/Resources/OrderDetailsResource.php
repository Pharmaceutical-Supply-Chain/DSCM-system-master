<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'attributes' => [
                'drug_amount' => $this->drug_amount,
                'production_date' => $this->production_date,
                'expiration_date' => $this->expiration_date,
                'drug_unit_price' => $this->drug_unit_price,
                'order_id' => $this->order_id,
                'stock_details_id' => $this->stock_details_id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
        ];
    }
}
