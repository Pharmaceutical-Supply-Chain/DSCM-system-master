<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockDetailsResource extends JsonResource
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
                'drug_residual' => $this->drug_residual,
                'drug_entry_date' => $this->drug_entry_date,
                'production_date' => $this->production_date,
                'expiration_date' => $this->expiration_date,
                'drug_unit_price' => $this->drug_unit_price,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'relationships' => [
                'drug' => [
                    'id' => (string)$this->drug->id,
                    'trade_name' => $this->drug->trade_name,
                    'drug_description' => $this->drug->drug_description,
                ],
                'stock' => [
                    'id' => (string)$this->stock->id,
                    'stock_number' => $this->stock->stock_number,
                ]
            ]
        ];
    }
}
