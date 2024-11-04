<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
     // Define relationship with ShippingCharge
     public function shippingCharges()
     {
         return $this->hasMany(ShippingCharge::class, 'city_id');
     }
    protected $table = 'city';
    protected $fillable = [
        'name',
        'code',
       
    ];
}
