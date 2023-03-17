<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'trade_name',
        'scientific_name',
        'drug_description',
        'production_date',
        'expiration_date',
        'drug_dose',
        'drug_amount',
        'drug_unit_price',
        'drug_total_cost',
        'drug_type',
        'order_id',
        'stock_details_id'

    ];
    protected $table='order_details';
    public function Order()
    {
        return $this->belongsTo(Order::class ,'order_id');
    }

    public function StockDetails()
    {
        return $this->belongsTo(StockDetails::class ,'stock_details_id');
    }

}
