<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    use HasFactory;
    public function country()
{
    return $this->belongsTo(Country::class, 'country_id');
}

public function state()
{
    return $this->belongsTo(States::class, 'state_id');
}

public function city()
{
    return $this->belongsTo(City::class, 'city_id');
}
}
