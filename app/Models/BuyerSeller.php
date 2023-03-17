<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerSeller extends Model
{
    use HasFactory;
    
    protected $table='buyer_seller';

    protected $fillable = [
        'id',
        'seller_id',
        'buyer_id',
        'order_id'

    ];

    public function buyer ()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    public function seller ()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function order ()
    {
        return $this->belongsTo(User::class, 'order_id', 'id');
    }
}
