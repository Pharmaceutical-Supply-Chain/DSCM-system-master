<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'drug_amount',
        'drug_entry_date',
        'drug_residual',
        'production_date',
        'expiration_date',
        'drug_unit_price',
        'stock_id',
        'drug_id',
    ];
    protected $table='stock_details';
    public function drug()
    {
        return $this->belongsTo(Drug::class,'drug_id');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class,'stock_id');
    }

    public function OrderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }
}
