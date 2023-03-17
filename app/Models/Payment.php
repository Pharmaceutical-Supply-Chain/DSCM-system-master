<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'payment_amount',
        'payment_date',
        'order_id',
        'payment_method_id',
    ];
    protected $table='payment';
    public function Order()
    {
        return $this->hasMany(Order::class ,'order_id');
    }

    public function OrdPaymentMethoder()
    {
        return $this->hasMany(PaymentMethod::class,'payment_method_id');
    }
}
