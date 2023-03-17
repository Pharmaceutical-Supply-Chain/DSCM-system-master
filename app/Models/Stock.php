<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'stock_number',
        'stock_location',
        'user_id',
        'stock_supervisor'
    ];
    protected $table='stock';
    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function StockDetails()
    {
        return $this->hasMany(StockDetails::class);
    }
}
