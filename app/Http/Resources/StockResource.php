<?php

namespace App\Http\Resources;

use App\Http\Resources\StockDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
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
                'stock_number' => $this->stock_number,
                'stock_location' => $this->stock_location,
                'stock_supervisor' => $this->stock_supervisor,
                'stock_details' => StockDetailsResource::collection($this->StockDetails),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'relationships' => [
                'id' => (string)$this->user->id,
                'user name' => $this->user->name,
                'user email' => $this->user->email
            ]
        ];
    }
}
