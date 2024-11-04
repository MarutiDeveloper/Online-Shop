<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use HasFactory;
    // Define relationship with ShippingCharge
    public function shippingCharges()
    {
        return $this->hasMany(ShippingCharge::class, 'state_id');
    }
}
