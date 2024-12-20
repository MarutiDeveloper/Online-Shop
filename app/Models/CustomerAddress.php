<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;
    // Set the table name explicitly if it differs from the pluralized version of the model name
    protected $table = 'customer_addresses'; 

    protected $fillable = ['user_id','first_name','last_name','email','mobile','country_id','address','apartment','state','city','zip'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
