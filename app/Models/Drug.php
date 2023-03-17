<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;
    protected $fillable = [
        'trade_name',
        'scientific_name',
        'drug_description',
        'drug_dose',
        'image',
        'drug_type_id'
    ];
    protected $table = 'drugs';
    public function StockDetails()
    {
        return $this->belongsTo(StockDetails::class);
    }

    public function drugType()
    {
        return $this->belongsTo(DrugType::class, 'drug_type_id');
    }
}
