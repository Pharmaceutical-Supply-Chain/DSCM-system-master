<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'order_description',
        'order_date',
        'order_total_cost',
        'status'
    ];
    protected $table='orders';
    // public function User()
    // {
    //     return $this->hasMany(User::class);
    // }

    public function Payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function OrderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function buyerSeller ()
    {
        return $this->hasOne(BuyerSeller::class);
    }
}
