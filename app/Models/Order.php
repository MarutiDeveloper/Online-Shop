<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected $table = 'orders';  // Specify the correct table name if different

  // Specify the fillable columns (make sure 'grand_total' is included)
  protected $fillable = [
    'user_id',
    'grand_total',  // Correct field name for the total
    'status',
    'created_at',
    'updated_at',
];

}
