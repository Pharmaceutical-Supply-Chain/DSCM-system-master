<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugType extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'drug_type_title',
        'drug_type_description',
    ];
    protected $table='drug_type';
    public function drug()
    {
        return $this->hasMany(Drug::class);
    }

}
