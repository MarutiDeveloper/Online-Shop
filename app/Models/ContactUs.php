<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $table = 'contact_us'; // Ensure the table name is correct

    protected $fillable = [
        'company_name',
        'company_address',
        'company_phone_number',
        'company_email',
    ];
}
